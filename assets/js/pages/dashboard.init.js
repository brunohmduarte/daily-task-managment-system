// const axios = require('axios');

// Ensure jQuery is available
if (typeof $ === 'undefined' && typeof jQuery !== 'undefined') {
    window.$ = jQuery;
}

!function($) {
    "use strict";

    var ChatApp = function() {
        this.$body = $("body"),
        this.$chatInput = $('.chat-input'),
        this.$chatList = $('.conversation-list'),
        this.$chatSendBtn = $('.chat-send'),
        this.$chatForm = $("#chat-form")
    };

    ChatApp.prototype.save = function() {
        var chatText = this.$chatInput.val();
        var chatTime = moment().format("h:mm");
        if (chatText == "") {
            this.$chatInput.focus();
            return false;
        } else {
            $('<li class="clearfix odd"><div class="chat-avatar"><img src="assets/images/users/avatar-1.jpg" alt="male"><i>' + chatTime + '</i></div><div class="conversation-text"><div class="ctext-wrap"><i>Dominic</i><p>' + chatText + '</p></div></div></li>').appendTo('.conversation-list');
            this.$chatInput.focus();
            this.$chatList.animate({ scrollTop: this.$chatList.prop("scrollHeight") + 100 }, 1000);
            return true;
        }
    }

    // init
    ChatApp.prototype.init = function () {
        var $this = this;
        //binding keypress event on chat input box - on enter we are adding the chat into chat list - 
        $this.$chatInput.keypress(function (ev) {
            var p = ev.which;
            if (p == 13) {
                $this.save();
                return false;
            }
        });

        //binding send button click
        $this.$chatForm.on('submit', function (ev) {
            ev.preventDefault();
            $this.save();
            $this.$chatInput.val('');

            setTimeout(function() {
                $this.$chatForm.removeClass('was-validated');
            });
            
            return false;
        });
    },
    //init ChatApp
    $.ChatApp = new ChatApp, $.ChatApp.Constructor = ChatApp
    
}(window.jQuery),

function ($) {
    "use strict";

    var Dashboard = function () { };

    Dashboard.prototype.initCharts = function() {
        window.Apex = {
            chart: {
                parentHeightOffset: 0,
                toolbar: {
                    show: false
                }
            },
            grid: {
                padding: {
                    left: 20,
                    right: 0
                }
            },
            colors: ["#5369f8", "#43d39e", "#f77e53", "#ffbe0b"],
            tooltip: {
                theme: 'dark',
                x: { show: false }
            }
        };

        var options2 = {
            chart: {
                type: 'area',
                height: 45,
                width: 90,
                sparkline: {
                    enabled: true
                }
            },
            series: [{
                data: [25, 66, 41, 85, 63, 25, 44, 12, 36, 9, 54]
            }],
            stroke: {
                width: 2,
                curve: 'smooth'
            },
            markers: {
                size: 0
            },
            colors: ["#727cf5"],
            tooltip: {
                fixed: {
                    enabled: false
                },
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function (seriesName) {
                            return ''
                        }
                    }
                },
                marker: {
                    show: false
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    type: "vertical",
                    shadeIntensity: 1,
                    inverseColors: false,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [45, 100]
                  },
            }
        }

        new ApexCharts(document.querySelector("#today-revenue-chart"), options2).render();
        new ApexCharts(document.querySelector("#today-product-sold-chart"), $.extend({}, options2, {colors: ['#f77e53']})).render();
        new ApexCharts(document.querySelector("#today-new-customer-chart"), $.extend({}, options2, {colors: ['#43d39e']})).render();
        new ApexCharts(document.querySelector("#today-new-visitors-chart"), $.extend({}, options2, {colors: ['#ffbe0b']})).render();

        // ------------------- revenue chart

        function getDaysInMonth(month, year) {
            var date = new Date(year, month, 1);
            var days = [];
            var idx = 0;
            while (date.getMonth() === month && idx < 15) {
                var d = new Date(date);
                days.push(d.getDate() + " " +  d.toLocaleString('pt-BR', { month: 'short' }));
                date.setDate(date.getDate() + 1);
                idx += 1;
            }
            return days;
        }

        var now = new Date();
        // var labels = getDaysInMonth(now.getMonth(), now.getFullYear());
        var alltimeStatsData = [];
        var alltimeStatsCategories = [];
        var options = {
            chart: {
                height: 329,
                type: 'area'
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 4
            },
            series: [{
                name: 'Tickets',
                data: alltimeStatsData
                // data: [10, 20, 5, 15, 10, 20, 15, 25, 20, 30, 25, 40, 30, 50, 35]
            }],
            zoom: {
                enabled: false
            },
            legend: {
                show: false
            },
            colors: ['#43d39e'],
            xaxis: {
                type: 'string',
                categories: alltimeStatsCategories,
                tooltip: {
                    enabled: false
                },
                axisBorder: {
                    show: false
                },
                labels: {
                    
                }
            },
            yaxis: {
                labels: {
                    formatter: function (val) {
                        return val //+ "k"
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    type: "vertical",
                    shadeIntensity: 1,
                    inverseColors: false,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [45, 100]
                  },
            },
        }

        // Expose chart instance so it can be updated later when AJAX data arrives
        this.revenueChart = new ApexCharts(
            document.querySelector("#revenue-chart"),
            options
        );

        this.revenueChart.render();

        /* ------------- target */
        var options = {
            chart: {
                height: 349,
                type: 'bar',
                stacked: true,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '45%',
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: [{
                name: 'Net Profit',
                data: [35, 44, 55, 57, 56, 61]
            }, {
                name: 'Revenue',
                data: [52, 76, 85, 101, 98, 87]
            }],
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                axisBorder: {
                    show: false
                },
            },
            legend: {
                show: false
            },
            grid: {
                row: {
                    colors: ['transparent', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.2
                },
                borderColor: '#f3f4f7'
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "$ " + val + " thousands"
                    }
                }
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#targets-chart"),
            options
        );

        chart.render();

        // sales by category --------------------------------------------------
        var options = {
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                    },
                    expandOnClick: false
                }
            },
            chart: {
                height: 291,
                type: 'donut',
            },
            legend: {
                show: true,
                position: 'right',
                horizontalAlign: 'left',
                itemMargin: {
                    horizontal: 6,
                    vertical: 3
                }
            },
            series: [44, 55, 41, 17],
            labels: ['Clothes 44k', 'Smartphons 55k', 'Electronics 41k', 'Other 17k'],
            responsive: [{
                breakpoint: 480,
                options: {
                    
                    legend: {
                        position: 'bottom'
                    }
                }
            }],
            tooltip: {
                y: {
                    formatter: function(value) { return value + "k" }
                },
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#sales-by-category-chart"),
            options
        );

        chart.render();
    },

    //initializing
    Dashboard.prototype.init = function () {
        // date picker
        $('#dash-daterange').flatpickr({
            mode: "range",
            defaultDate: [moment().subtract(7, 'days').format('YYYY-MM-DD'), moment().format('YYYY-MM-DD')]
        });

        // calendar
        $('#calendar-widget').flatpickr({
            inline: true,
            shorthandCurrentMonth: true,
        });

        // chat
        $.ChatApp.init();

        // charts
        this.initCharts();
    },

    
    $.Dashboard = new Dashboard, $.Dashboard.Constructor = Dashboard

}(window.jQuery),

// Ajax helper to load data from backend and update charts
function ($) {
    "use strict";
    var AjaxRequest = function() {
        this.allTimeStatistics = [];
        this.alltimeStatsData = [];
        this.alltimeStatsCategories = [];
    };

    AjaxRequest.prototype.init = function() {
        this.getAllTimeStatistics();
    };

    // Fetch all-time statistics from backend API
    AjaxRequest.prototype.getAllTimeStatistics = function() {
        var self = this;
        $.ajax({
            url: 'api/index.php?action=getAllTimeStatistics',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                // Store raw data
                self.allTimeStatistics = (response && response.data) ? response.data : [];
                
                // Process data for chart
                self.processChartData();
                
                // Update chart with new data
                self.updateCharts();
            },
            error: function(xhr, status, err) {
                console.error('Failed to load all-time statistics', status, err);
                self.allTimeStatistics = [];
                self.alltimeStatsData = [];
                self.alltimeStatsCategories = [];
            }
        });
    };

    // Process data for chart ticket volume
    AjaxRequest.prototype.processChartData = function() {
        var stats = this.allTimeStatistics || [];
        
        if (!stats.length) {
            this.alltimeStatsData = [];
            this.alltimeStatsCategories = [];
            return;
        }

        // Sort ascending by month so chart displays chronologically
        stats.sort(function(a, b) { 
            return new Date(a.month || a.mes_numero) - new Date(b.month || b.mes_numero); 
        });

        // Extract labels and data
        this.alltimeStatsCategories = stats.map(function(item) {
            console.log('Processing item month:', item);
            var date = new Date(item.ano, item.mes_numero, 1);
            return date.toLocaleString('pt-BR', { month: 'short', year: 'numeric' });
        });

        this.alltimeStatsData = stats.map(function(item) {
            return Number(item.count || item.total_tickets);
        });

        console.log('Chart Data Processed:', {
            categories: this.alltimeStatsCategories,
            data: this.alltimeStatsData
        });
    };

    AjaxRequest.prototype.updateCharts = function() {
        // Update revenue chart if exists
        if ($.Dashboard && $.Dashboard.revenueChart) {
            $.Dashboard.revenueChart.updateOptions({ 
                xaxis: { 
                    categories: this.alltimeStatsCategories 
                } 
            });
            $.Dashboard.revenueChart.updateSeries([{ 
                name: 'Tickets', 
                data: this.alltimeStatsData 
            }]);
        }
    };

    // Expose instance so you can access data anywhere
    $.AjaxRequest = new AjaxRequest();
    $.AjaxRequest.Constructor = AjaxRequest;

    // Init sequence: load data then init dashboard
    $(function() {
        $.AjaxRequest.init();
        $.Dashboard.init();
    });

}(window.jQuery);
