var selectedColor;
const second = 1000; //1000 miliseconds

var TimeLine = {
    me: false,
    splitter: 3600,
    items: [],

    //Gets vis.js groups aka Users
    init: function() {

        let me = this;

        $.ajax({
            method: "POST",
            url: window.location.href + 'api/v1/users',
            dataType: 'json',
            headers: {
                'Authorization':'Bearer ' + token,
            },
        })
        .done(function( response ) {
            me.getItems( function() {
                me.draw( response );
            });
        });

    },

    getItems: function( callback ) {

        let me = this;

        $.ajax({
            method: "POST",
            url: window.location.href + 'api/v1/get-user-times',
            dataType: 'json',
            headers: {
                'Authorization':'Bearer ' + token,
            },
        })
        .done(function( response ) {

            let dataSetArr = [];

            for(let i=0; i<response.length; i++)
            {
                dataSetArr.push({
                    id     : response[i].id,
                    group  : response[i].group,
                    start  : new Date( response[i].start ),
                    end    : new Date( response[i].end ),
                    content: response[i].content,
                    style  : response[i].style
                });
            }

            me.items = new vis.DataSet(dataSetArr);
            callback();
        });
    },

    draw: function( groups ) {

        let zoomMax = second * this.splitter * 10;   //10 tickes
        let stepScale = 'second', step = this.splitter;

        if( this.splitter > 60 ) {
            stepScale = 'minute';
            step = this.splitter / 60;
        }

        // create visualization
        let container = document.getElementById('visualization');
        let options = {
            // option groupOrder can be a property name or a sort function
            // the sort function must compare two groups and return a value
            //     > 0 when a > b
            //     < 0 when a < b
            //       0 when a == b
            groupOrder: function (a, b) {
                return a.value - b.value;
            },
            editable: false,
            zoomMin: 1000,
            zoomMax: zoomMax,
            timeAxis: {
                scale: stepScale,
                step : step
            },
            zoomable: false,
            horizontalScroll: true
        };

        this.me = new vis.Timeline(container);
        this.me.setOptions(options);
        this.me.setGroups(groups);
        this.me.setItems(this.items);

    },

    destroy: function()
    {
        this.me.destroy();
    },

    redraw: function()
    {
        this.destroy();

        this.init();
    }
};

var User = {

    changeStatus: function( status, userId ) {

        $.ajax({
            method: "POST",
            url: window.location.href + 'api/v1/change-user-status',
            dataType: 'json',
            headers: {
                'Authorization':'Bearer ' + token,
            },
            data: { userId: userId, status: status }
        })
        .done(function( response ) {
            TimeLine.redraw();
        });

    },

    saveColor: function( color, userId, callback ) {

        $.ajax({
            method: "POST",
            url: window.location.href + 'api/v1/save-user-color',
            dataType: 'json',
            headers: {
                'Authorization':'Bearer ' + token,
            },
            data: { userId: userId, color: color }
        })
        .done(function() {

            TimeLine.redraw();
            callback();

        });

    }

};

$(document).ready(function() {


    //Bind events
    $('#rangeSplitter').mouseup(function() {

        TimeLine.splitter = parseInt( $(this).val() );
        TimeLine.redraw();

    });

    $('.switch-user-status').change(function() {

        let userId = $(this).data('userid');
        let status = $(this).is(':checked');

        User.changeStatus( status, userId );

    });

    $('.color-picker').ColorPicker({
        color: '#0000ff',
        onShow: function (colpkr) {
            selectedColor = $(this);
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onSubmit: function (hsb, hex, rgb) {

            let userId = selectedColor.data('userid');
            let color = '#' + hex;

            User.saveColor( color, userId, function() {
                selectedColor.css('backgroundColor', '#' + hex);
            });

        }
    });

    TimeLine.init();

});

