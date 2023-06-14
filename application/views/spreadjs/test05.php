<style>
    body {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
    }
</style>
<script type="text/javascript">
       window.onload = function() {
        var spread = new GC.Spread.Sheets.Workbook(document.getElementById('ss'));
        spread.suspendPaint();      
 
        spread.fromJSON(data[0]);
        var sheet = spread.getActiveSheet();

        sheet.frozenRowCount(4);
        sheet.frozenColumnCount(3);
        sheet.frozenTrailingRowCount(1, false);
        sheet.frozenTrailingColumnCount(1, false);
        sheet.options.gridline.showHorizontalGridline = false;
        sheet.options.gridline.showVerticalGridline = false;
        sheet.options.frozenlineColor = 'rgb(247, 167, 17)';

        spread.options.scrollbarMaxAlign = true;
     
        spread.resumePaint();
        _getElementById('btnSetFrozenLine').addEventListener('click', function() {

            if (_getElementById('rowCount').value) {
                var rowCount = parseInt(_getElementById('rowCount').value);
                sheet.frozenRowCount(rowCount);
            }
            if (_getElementById('trailingRowCount').value) {
                var trailingRowCount = parseInt(_getElementById('trailingRowCount').value);
                var rowStickToEdge = _getElementById('rowStickToEdge').checked;
                sheet.frozenTrailingRowCount(trailingRowCount, rowStickToEdge);
            }
            if (_getElementById('columnCount').value) {
                var columnCount = parseInt(_getElementById('columnCount').value);
                sheet.frozenColumnCount(columnCount);
            }
            if (_getElementById('trailingColumnCount').value) {
                var trailingColumnCount = parseInt(_getElementById('trailingColumnCount').value);
                var columnStickToEdge = _getElementById('columnStickToEdge').checked;
                sheet.frozenTrailingColumnCount(trailingColumnCount, columnStickToEdge);
            }
        });
    };
    function _getElementById(id){
        return document.getElementById(id);
    }
    var data = [{
    "version": "15.2.5",
    "sheetCount": 1,
    "tabStripRatio": 0.6,
    "customList": [],
    "activeSheetIndex": 0,
    "sheets": {
        "Sheet1": {
            "name": "Sheet1",
            "isSelected": true,
            "rowCount": 33,
            "columnCount": 11,
            "activeRow": 5,
            "activeCol": 3,
            "theme": {
                "name": "Office",
                "themeColor": {
                    "name": "Office",
                    "background1": {
                        "a": 255,
                        "r": 255,
                        "g": 255,
                        "b": 255
                    },
                    "background2": {
                        "a": 255,
                        "r": 231,
                        "g": 230,
                        "b": 230
                    },
                    "text1": {
                        "a": 255,
                        "r": 0,
                        "g": 0,
                        "b": 0
                    },
                    "text2": {
                        "a": 255,
                        "r": 68,
                        "g": 84,
                        "b": 106
                    },
                    "accent1": {
                        "a": 255,
                        "r": 68,
                        "g": 114,
                        "b": 196
                    },
                    "accent2": {
                        "a": 255,
                        "r": 237,
                        "g": 125,
                        "b": 49
                    },
                    "accent3": {
                        "a": 255,
                        "r": 165,
                        "g": 165,
                        "b": 165
                    },
                    "accent4": {
                        "a": 255,
                        "r": 255,
                        "g": 192,
                        "b": 0
                    },
                    "accent5": {
                        "a": 255,
                        "r": 91,
                        "g": 155,
                        "b": 213
                    },
                    "accent6": {
                        "a": 255,
                        "r": 112,
                        "g": 173,
                        "b": 71
                    },
                    "hyperlink": {
                        "a": 255,
                        "r": 5,
                        "g": 99,
                        "b": 193
                    },
                    "followedHyperlink": {
                        "a": 255,
                        "r": 149,
                        "g": 79,
                        "b": 114
                    }
                },
                "headingFont": "Calibri Light",
                "bodyFont": "Calibri"
            },
            "data": {
                "dataTable": {
                    "2": {
                        "2": {
                            "value": "Weather Card",
                            "style": "__builtInStyle17"
                        },
                        "3": {
                            "style": "__builtInStyle17"
                        },
                        "4": {
                            "style": "__builtInStyle17"
                        },
                        "5": {
                            "style": "__builtInStyle17"
                        },
                        "6": {
                            "style": "__builtInStyle17"
                        },
                        "7": {
                            "style": "__builtInStyle17"
                        },
                        "8": {
                            "style": "__builtInStyle17"
                        },
                        "9": {
                            "style": "__builtInStyle17"
                        },
                        "10": {
                            "style": "__builtInStyle17"
                        }
                    },
                    "3": {
                        "2": {
                            "value": "Date",
                            "style": "__builtInStyle5"
                        },
                        "3": {
                            "value": "Max Temperature (F)",
                            "style": "__builtInStyle10"
                        },
                        "4": {
                            "value": "Min Temperature (F)",
                            "style": "__builtInStyle2"
                        },
                        "5": {
                            "value": "Precipitation",
                            "style": "__builtInStyle2"
                        },
                        "6": {
                            "value": "Cloud Cover",
                            "style": "__builtInStyle2"
                        },
                        "7": {
                            "value": "Visiblity (miles)",
                            "style": "__builtInStyle2"
                        },
                        "8": {
                            "value": "Wind (mph)",
                            "style": "__builtInStyle2"
                        },
                        "9": {
                            "value": "Humidity",
                            "style": "__builtInStyle2"
                        },
                        "10": {
                            "value": "Forecast",
                            "style": "__builtInStyle2"
                        }
                    },
                    "4": {
                        "2": {
                            "value": "/OADate(44228)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 19,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 19,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0.8,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 1,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 10,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 11,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.76,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Rainy",
                            "style": "__builtInStyle3"
                        }
                    },
                    "5": {
                        "2": {
                            "value": "/OADate(44229)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 23,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 15,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0.2,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.98,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 13,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 19,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.62,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Mostly Cloudy",
                            "style": "__builtInStyle3"
                        }
                    },
                    "6": {
                        "2": {
                            "value": "/OADate(44230)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 24,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 14,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0.9,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.99,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 12,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 14,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.77,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Thunderstorm",
                            "style": "__builtInStyle3"
                        }
                    },
                    "7": {
                        "2": {
                            "value": "/OADate(44231)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 24,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 14,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0.1,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.74,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 14,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 26,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.56,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Partly Cloudy",
                            "style": "__builtInStyle3"
                        }
                    },
                    "8": {
                        "2": {
                            "value": "/OADate(44232)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 27,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 17,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0.1,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.82,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 12,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 11,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.57,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Partly Cloudy",
                            "style": "__builtInStyle3"
                        }
                    },
                    "9": {
                        "2": {
                            "value": "/OADate(44233)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 27,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 19,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0.2,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.88,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 9,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 16,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.71,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Cloudy",
                            "style": "__builtInStyle3"
                        }
                    },
                    "10": {
                        "2": {
                            "value": "/OADate(44234)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 28,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 18,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0.1,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.82,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 12,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 11,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.57,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Most Sunny",
                            "style": "__builtInStyle3"
                        }
                    },
                    "11": {
                        "2": {
                            "value": "/OADate(44235)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 28,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 17,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.01,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 18,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 19,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.53,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Most Sunny",
                            "style": "__builtInStyle3"
                        }
                    },
                    "12": {
                        "2": {
                            "value": "/OADate(44236)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 29,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 21,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.01,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 19,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 11,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.59,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Sunny",
                            "style": "__builtInStyle3"
                        }
                    },
                    "13": {
                        "2": {
                            "value": "/OADate(44237)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 28,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 17,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.01,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 18,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 19,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.53,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Most Sunny",
                            "style": "__builtInStyle3"
                        }
                    },
                    "14": {
                        "2": {
                            "value": "/OADate(44238)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 28,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 19,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0.1,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.63,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 13,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 15,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.6,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Cloudy",
                            "style": "__builtInStyle3"
                        }
                    },
                    "15": {
                        "2": {
                            "value": "/OADate(44239)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 24,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 18,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0.4,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.79,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 15,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 17,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.66,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Partly Cloudy",
                            "style": "__builtInStyle3"
                        }
                    },
                    "16": {
                        "2": {
                            "value": "/OADate(44240)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 25,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 16,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0.7,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.99,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 13,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 14,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.72,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Rainy",
                            "style": "__builtInStyle3"
                        }
                    },
                    "17": {
                        "2": {
                            "value": "/OADate(44241)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 27,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 17,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0.1,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.93,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 12,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 11,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.57,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Partly Cloudy",
                            "style": "__builtInStyle3"
                        }
                    },
                    "18": {
                        "2": {
                            "value": "/OADate(44242)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 27,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 19,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0.2,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.69,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 14,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 16,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.71,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Cloudy",
                            "style": "__builtInStyle3"
                        }
                    },
                    "19": {
                        "2": {
                            "value": "/OADate(44243)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 28,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 18,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0.1,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.04,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 20,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 18,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.6,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Most Sunny",
                            "style": "__builtInStyle3"
                        }
                    },
                    "20": {
                        "2": {
                            "value": "/OADate(44244)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 28,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 17,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.05,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 20,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 19,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.53,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Most Sunny",
                            "style": "__builtInStyle3"
                        }
                    },
                    "21": {
                        "2": {
                            "value": "/OADate(44245)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 29,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 21,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 21,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 11,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.59,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Sunny",
                            "style": "__builtInStyle3"
                        }
                    },
                    "22": {
                        "2": {
                            "value": "/OADate(44246)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 28,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 19,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0.1,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.56,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 10,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 15,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.6,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Cloudy",
                            "style": "__builtInStyle3"
                        }
                    },
                    "23": {
                        "2": {
                            "value": "/OADate(44247)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 24,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 18,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0.4,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.78,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 12,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 17,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.66,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Partly Cloudy",
                            "style": "__builtInStyle3"
                        }
                    },
                    "24": {
                        "2": {
                            "value": "/OADate(44248)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 25,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 16,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0.7,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.99,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 13,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 14,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.72,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Rainy",
                            "style": "__builtInStyle3"
                        }
                    },
                    "25": {
                        "2": {
                            "value": "/OADate(44249)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 27,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 17,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0.1,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.93,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 12,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 11,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.57,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Partly Cloudy",
                            "style": "__builtInStyle3"
                        }
                    },
                    "26": {
                        "2": {
                            "value": "/OADate(44250)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 27,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 19,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0.2,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.69,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 14,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 16,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.71,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Cloudy",
                            "style": "__builtInStyle3"
                        }
                    },
                    "27": {
                        "2": {
                            "value": "/OADate(44251)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 28,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 18,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0.1,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.04,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 20,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 18,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.6,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Most Sunny",
                            "style": "__builtInStyle3"
                        }
                    },
                    "28": {
                        "2": {
                            "value": "/OADate(44252)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 28,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 17,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.05,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 20,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 19,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.53,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Most Sunny",
                            "style": "__builtInStyle3"
                        }
                    },
                    "29": {
                        "2": {
                            "value": "/OADate(44253)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 29,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 21,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 21,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 11,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.59,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Sunny",
                            "style": "__builtInStyle3"
                        }
                    },
                    "30": {
                        "2": {
                            "value": "/OADate(44254)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 28,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 19,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0.1,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.56,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 10,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 15,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.6,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Cloudy",
                            "style": "__builtInStyle3"
                        }
                    },
                    "31": {
                        "2": {
                            "value": "/OADate(44255)/",
                            "style": "__builtInStyle6"
                        },
                        "3": {
                            "value": 24,
                            "style": "__builtInStyle12"
                        },
                        "4": {
                            "value": 18,
                            "style": "__builtInStyle12"
                        },
                        "5": {
                            "value": 0.4,
                            "style": "__builtInStyle14"
                        },
                        "6": {
                            "value": 0.78,
                            "style": "__builtInStyle16"
                        },
                        "7": {
                            "value": 12,
                            "style": "__builtInStyle8"
                        },
                        "8": {
                            "value": 17,
                            "style": "__builtInStyle8"
                        },
                        "9": {
                            "value": 0.66,
                            "style": "__builtInStyle14"
                        },
                        "10": {
                            "value": "Partly Cloudy",
                            "style": "__builtInStyle3"
                        }
                    },
                    "32": {
                        "2": {
                            "value": "Average",
                            "style": "__builtInStyle5"
                        },
                        "3": {
                            "value": 26.4642857142857,
                            "style": "__builtInStyle13",
                            "formula": "AVERAGE(D5:D32)"
                        },
                        "4": {
                            "value": 17.7857142857143,
                            "style": "__builtInStyle13",
                            "formula": "AVERAGE(E5:E32)"
                        },
                        "5": {
                            "value": 0.217857142857143,
                            "style": "__builtInStyle15",
                            "formula": "AVERAGE(F5:F32)"
                        },
                        "6": {
                            "value": 0.562857142857143,
                            "style": "__builtInStyle15",
                            "formula": "AVERAGE(G5:G32)"
                        },
                        "7": {
                            "value": 14.6071428571429,
                            "style": "__builtInStyle9",
                            "formula": "AVERAGE(H5:H32)"
                        },
                        "8": {
                            "value": 15.3928571428571,
                            "style": "__builtInStyle9",
                            "formula": "AVERAGE(I5:I32)"
                        },
                        "9": {
                            "value": 0.6225,
                            "style": "__builtInStyle15",
                            "formula": "AVERAGE(J5:J32)"
                        },
                        "10": {
                            "style": "__builtInStyle4"
                        }
                    }
                },
                "columnDataArray": [null, null, {
                    "style": "__builtInStyle7"
                }, {
                    "style": "__builtInStyle11"
                }],
                "defaultDataNode": {
                    "style": {
                        "backColor": null,
                        "foreColor": "Text 1 0",
                        "vAlign": 2,
                        "font": "normal normal 16px Calibri",
                        "themeFont": "Body",
                        "borderLeft": null,
                        "borderTop": null,
                        "borderRight": null,
                        "borderBottom": null,
                        "locked": true,
                        "textIndent": 0,
                        "wordWrap": false,
                        "diagonalDown": null,
                        "diagonalUp": null
                    }
                }
            },
            "rowHeaderData": {
                "defaultDataNode": {
                    "style": {
                        "themeFont": "Body"
                    }
                }
            },
            "colHeaderData": {
                "defaultDataNode": {
                    "style": {
                        "themeFont": "Body"
                    }
                }
            },
            "rows": [null, null, {
                "size": 35
            }, {
                "size": 21
            }, {
                "size": 21
            }, {
                "size": 26
            }, {
                "size": 23
            }, {
                "size": 21
            }, {
                "size": 22
            }, {
                "size": 21
            }, {
                "size": 21
            }, {
                "size": 21
            }, {
                "size": 21
            }, {
                "size": 21
            }, {
                "size": 21
            }, {
                "size": 17
            }, {
                "size": 21
            }, {
                "size": 22
            }, {
                "size": 21
            }, {
                "size": 21
            }, {
                "size": 21
            }, {
                "size": 21
            }, {
                "size": 21
            }, {
                "size": 21
            }, {
                "size": 21
            }, {
                "size": 21
            }, {
                "size": 21
            }, {
                "size": 21
            }, {
                "size": 21
            }, {
                "size": 21
            }, {
                "size": 21
            }, {
                "size": 21
            }, {
                "size": 21
            }],
            "columns": [null, null, {
                "size": 132
            }, {
                "size": 133
            }, {
                "size": 126
            }, {
                "size": 122
            }, {
                "size": 111
            }, {
                "size": 126
            }, {
                "size": 141
            }, {
                "size": 116
            }, {
                "size": 184
            }],
            "leftCellIndex": 0,
            "topCellIndex": 0,
            "spans": [{
                "row": 2,
                "rowCount": 1,
                "col": 2,
                "colCount": 9
            }],
            "selections": {
                "0": {
                    "row": 5,
                    "rowCount": 1,
                    "col": 3,
                    "colCount": 1
                },
                "length": 1
            },
            "defaults": {
                "colHeaderRowHeight": 20,
                "colWidth": 20,
                "rowHeaderColWidth": 40,
                "rowHeight": 20.8,
                "_isExcelDefaultColumnWidth": true
            },
            "rowOutlines": {
                "items": []
            },
            "columnOutlines": {
                "items": []
            },
            "cellStates": {},
            "outlineColumnOptions": {},
            "autoMergeRangeInfos": [],
            "index": 0
        }
    },
    "namedStyles": [{
        "backColor": "Accent 1 80",
        "foreColor": "Text 1 0",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "20% - Accent1"
    }, {
        "backColor": "Accent 2 80",
        "foreColor": "Text 1 0",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "20% - Accent2"
    }, {
        "backColor": "Accent 3 80",
        "foreColor": "Text 1 0",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "20% - Accent3"
    }, {
        "backColor": "Accent 4 80",
        "foreColor": "Text 1 0",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "20% - Accent4"
    }, {
        "backColor": "Accent 5 80",
        "foreColor": "Text 1 0",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "20% - Accent5"
    }, {
        "backColor": "Accent 6 80",
        "foreColor": "Text 1 0",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "20% - Accent6"
    }, {
        "backColor": "Accent 1 60",
        "foreColor": "Text 1 0",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "40% - Accent1"
    }, {
        "backColor": "Accent 2 60",
        "foreColor": "Text 1 0",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "40% - Accent2"
    }, {
        "backColor": "Accent 3 60",
        "foreColor": "Text 1 0",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "40% - Accent3"
    }, {
        "backColor": "Accent 4 60",
        "foreColor": "Text 1 0",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "40% - Accent4"
    }, {
        "backColor": "Accent 5 60",
        "foreColor": "Text 1 0",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "40% - Accent5"
    }, {
        "backColor": "Accent 6 60",
        "foreColor": "Text 1 0",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "40% - Accent6"
    }, {
        "backColor": "Accent 1 40",
        "foreColor": "Background 1 0",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "60% - Accent1"
    }, {
        "backColor": "Accent 2 40",
        "foreColor": "Background 1 0",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "60% - Accent2"
    }, {
        "backColor": "Accent 3 40",
        "foreColor": "Background 1 0",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "60% - Accent3"
    }, {
        "backColor": "Accent 4 40",
        "foreColor": "Background 1 0",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "60% - Accent4"
    }, {
        "backColor": "Accent 5 40",
        "foreColor": "Background 1 0",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "60% - Accent5"
    }, {
        "backColor": "Accent 6 40",
        "foreColor": "Background 1 0",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "60% - Accent6"
    }, {
        "backColor": "Accent 1 0",
        "foreColor": "Background 1 0",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "Accent1"
    }, {
        "backColor": "Accent 2 0",
        "foreColor": "Background 1 0",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "Accent2"
    }, {
        "backColor": "Accent 3 0",
        "foreColor": "Background 1 0",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "Accent3"
    }, {
        "backColor": "Accent 4 0",
        "foreColor": "Background 1 0",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "Accent4"
    }, {
        "backColor": "Accent 5 0",
        "foreColor": "Background 1 0",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "Accent5"
    }, {
        "backColor": "Accent 6 0",
        "foreColor": "Background 1 0",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "Accent6"
    }, {
        "backColor": "#ffc7ce",
        "foreColor": "#9c0006",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "Bad"
    }, {
        "backColor": "#f2f2f2",
        "foreColor": "#fa7d00",
        "font": "normal bold 14.7px Calibri",
        "themeFont": "Body",
        "borderLeft": {
            "color": "#7f7f7f",
            "style": 1
        },
        "borderTop": {
            "color": "#7f7f7f",
            "style": 1
        },
        "borderRight": {
            "color": "#7f7f7f",
            "style": 1
        },
        "borderBottom": {
            "color": "#7f7f7f",
            "style": 1
        },
        "name": "Calculation",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": "#a5a5a5",
        "foreColor": "Background 1 0",
        "font": "normal bold 14.7px Calibri",
        "themeFont": "Body",
        "borderLeft": {
            "color": "#3f3f3f",
            "style": 6
        },
        "borderTop": {
            "color": "#3f3f3f",
            "style": 6
        },
        "borderRight": {
            "color": "#3f3f3f",
            "style": 6
        },
        "borderBottom": {
            "color": "#3f3f3f",
            "style": 6
        },
        "name": "Check Cell",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": null,
        "formatter": "_(* #,##0.00_);_(* (#,##0.00);_(* \"-\"??_);_(@_)",
        "name": "Comma"
    }, {
        "backColor": null,
        "formatter": "_(* #,##0_);_(* (#,##0);_(* \"-\"_);_(@_)",
        "name": "Comma [0]"
    }, {
        "backColor": null,
        "formatter": "_(\"$\"* #,##0.00_);_(\"$\"* (#,##0.00);_(\"$\"* \"-\"??_);_(@_)",
        "name": "Currency"
    }, {
        "backColor": null,
        "formatter": "_(\"$\"* #,##0_);_(\"$\"* (#,##0);_(\"$\"* \"-\"_);_(@_)",
        "name": "Currency [0]"
    }, {
        "backColor": null,
        "foreColor": "#7f7f7f",
        "font": "italic normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "Explanatory Text"
    }, {
        "backColor": "#c6efce",
        "foreColor": "#006100",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "Good"
    }, {
        "backColor": null,
        "foreColor": "Text 2 0",
        "font": "normal bold 20px Calibri",
        "themeFont": "Body",
        "borderLeft": null,
        "borderTop": null,
        "borderRight": null,
        "borderBottom": {
            "color": "Accent 1 0",
            "style": 5
        },
        "name": "Heading 1",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": null,
        "foreColor": "Text 2 0",
        "font": "normal bold 17.3px Calibri",
        "themeFont": "Body",
        "borderLeft": null,
        "borderTop": null,
        "borderRight": null,
        "borderBottom": {
            "color": "Accent 1 50",
            "style": 5
        },
        "name": "Heading 2",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": null,
        "foreColor": "Text 2 0",
        "font": "normal bold 14.7px Calibri",
        "themeFont": "Body",
        "borderLeft": null,
        "borderTop": null,
        "borderRight": null,
        "borderBottom": {
            "color": "Accent 1 40",
            "style": 2
        },
        "name": "Heading 3",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": null,
        "foreColor": "Text 2 0",
        "font": "normal bold 14.7px Calibri",
        "themeFont": "Body",
        "name": "Heading 4"
    }, {
        "backColor": "#ffcc99",
        "foreColor": "#3f3f76",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "borderLeft": {
            "color": "#7f7f7f",
            "style": 1
        },
        "borderTop": {
            "color": "#7f7f7f",
            "style": 1
        },
        "borderRight": {
            "color": "#7f7f7f",
            "style": 1
        },
        "borderBottom": {
            "color": "#7f7f7f",
            "style": 1
        },
        "name": "Input",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": null,
        "foreColor": "#fa7d00",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "borderLeft": null,
        "borderTop": null,
        "borderRight": null,
        "borderBottom": {
            "color": "#ff8001",
            "style": 6
        },
        "name": "Linked Cell",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": "#ffeb9c",
        "foreColor": "#9c6500",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "Neutral"
    }, {
        "backColor": null,
        "foreColor": "Text 1 0",
        "hAlign": 3,
        "vAlign": 2,
        "font": "normal normal 16px Calibri",
        "themeFont": "Body",
        "borderLeft": null,
        "borderTop": null,
        "borderRight": null,
        "borderBottom": null,
        "locked": true,
        "textIndent": 0,
        "wordWrap": false,
        "name": "Normal",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": "#ffffcc",
        "borderLeft": {
            "color": "#b2b2b2",
            "style": 1
        },
        "borderTop": {
            "color": "#b2b2b2",
            "style": 1
        },
        "borderRight": {
            "color": "#b2b2b2",
            "style": 1
        },
        "borderBottom": {
            "color": "#b2b2b2",
            "style": 1
        },
        "name": "Note",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": "#f2f2f2",
        "foreColor": "#3f3f3f",
        "font": "normal bold 14.7px Calibri",
        "themeFont": "Body",
        "borderLeft": {
            "color": "#3f3f3f",
            "style": 1
        },
        "borderTop": {
            "color": "#3f3f3f",
            "style": 1
        },
        "borderRight": {
            "color": "#3f3f3f",
            "style": 1
        },
        "borderBottom": {
            "color": "#3f3f3f",
            "style": 1
        },
        "name": "Output",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": null,
        "formatter": "0%",
        "name": "Percent"
    }, {
        "backColor": null,
        "foreColor": "Text 2 0",
        "font": "normal bold 24px Calibri Light",
        "themeFont": "Headings",
        "name": "Title"
    }, {
        "backColor": null,
        "foreColor": "Text 1 0",
        "font": "normal bold 14.7px Calibri",
        "themeFont": "Body",
        "borderLeft": null,
        "borderTop": {
            "color": "Accent 1 0",
            "style": 1
        },
        "borderRight": null,
        "borderBottom": {
            "color": "Accent 1 0",
            "style": 6
        },
        "name": "Total",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": null,
        "foreColor": "#ff0000",
        "font": "normal normal 14.7px Calibri",
        "themeFont": "Body",
        "name": "Warning Text"
    }, {
        "backColor": null,
        "foreColor": "Text 1 0",
        "hAlign": 3,
        "vAlign": 2,
        "font": "normal normal 16px Calibri",
        "themeFont": "Body",
        "formatter": "General",
        "borderLeft": null,
        "borderTop": null,
        "borderRight": null,
        "borderBottom": null,
        "locked": true,
        "textIndent": 0,
        "wordWrap": false,
        "name": "__builtInStyle1",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": "Background 1 -15",
        "foreColor": "#000000",
        "hAlign": 1,
        "vAlign": 1,
        "font": "normal bold 12px Calibri Light",
        "formatter": "General",
        "borderLeft": null,
        "borderTop": null,
        "borderRight": null,
        "borderBottom": null,
        "locked": true,
        "textIndent": 0,
        "wordWrap": true,
        "name": "__builtInStyle2",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": "Background 1 -5",
        "foreColor": "#000000",
        "hAlign": 1,
        "vAlign": 1,
        "font": "normal normal 12px Calibri",
        "formatter": "General",
        "borderLeft": null,
        "borderTop": null,
        "borderRight": null,
        "borderBottom": null,
        "locked": true,
        "textIndent": 0,
        "wordWrap": true,
        "name": "__builtInStyle3",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": "Background 1 -15",
        "foreColor": "#000000",
        "hAlign": 1,
        "vAlign": 1,
        "font": "normal normal 12px Calibri",
        "formatter": "General",
        "borderLeft": null,
        "borderTop": null,
        "borderRight": null,
        "borderBottom": null,
        "locked": true,
        "textIndent": 0,
        "wordWrap": true,
        "name": "__builtInStyle4",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": "Background 1 -15",
        "foreColor": "#000000",
        "hAlign": 1,
        "vAlign": 1,
        "font": "normal bold 12px Calibri",
        "formatter": "yyyy\\-mm\\-dd;@",
        "borderLeft": null,
        "borderTop": null,
        "borderRight": null,
        "borderBottom": null,
        "locked": true,
        "textIndent": 0,
        "wordWrap": true,
        "name": "__builtInStyle5",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": "Background 1 -5",
        "foreColor": "#000000",
        "hAlign": 1,
        "vAlign": 1,
        "font": "normal normal 12px Calibri",
        "formatter": "yyyy\\-mm\\-dd;@",
        "borderLeft": null,
        "borderTop": null,
        "borderRight": null,
        "borderBottom": null,
        "locked": true,
        "textIndent": 0,
        "wordWrap": true,
        "name": "__builtInStyle6",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": null,
        "foreColor": "Text 1 0",
        "hAlign": 3,
        "vAlign": 2,
        "font": "normal normal 16px Calibri",
        "themeFont": "Body",
        "formatter": "yyyy\\-mm\\-dd;@",
        "borderLeft": null,
        "borderTop": null,
        "borderRight": null,
        "borderBottom": null,
        "locked": true,
        "textIndent": 0,
        "wordWrap": false,
        "name": "__builtInStyle7",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": null,
        "foreColor": "#000000",
        "hAlign": 1,
        "vAlign": 1,
        "font": "normal normal 12px Calibri",
        "formatter": "0",
        "borderLeft": null,
        "borderTop": null,
        "borderRight": null,
        "borderBottom": null,
        "locked": true,
        "textIndent": 0,
        "wordWrap": true,
        "name": "__builtInStyle8",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": "Background 1 -15",
        "foreColor": "#000000",
        "hAlign": 1,
        "vAlign": 1,
        "font": "normal bold 12px Calibri",
        "formatter": "0",
        "borderLeft": null,
        "borderTop": null,
        "borderRight": null,
        "borderBottom": null,
        "locked": true,
        "textIndent": 0,
        "wordWrap": true,
        "name": "__builtInStyle9",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": "Background 1 -15",
        "foreColor": "#000000",
        "hAlign": 1,
        "vAlign": 1,
        "font": "normal bold 12px Calibri Light",
        "formatter": "0",
        "borderLeft": null,
        "borderTop": null,
        "borderRight": null,
        "borderBottom": null,
        "locked": true,
        "textIndent": 0,
        "wordWrap": true,
        "name": "__builtInStyle10",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": null,
        "foreColor": "Text 1 0",
        "hAlign": 3,
        "vAlign": 2,
        "font": "normal normal 16px Calibri",
        "themeFont": "Body",
        "formatter": "0",
        "borderLeft": null,
        "borderTop": null,
        "borderRight": null,
        "borderBottom": null,
        "locked": true,
        "textIndent": 0,
        "wordWrap": false,
        "name": "__builtInStyle11",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": null,
        "foreColor": "#000000",
        "hAlign": 1,
        "vAlign": 1,
        "font": "normal normal 12px Calibri",
        "formatter": "0\\ \\F",
        "borderLeft": null,
        "borderTop": null,
        "borderRight": null,
        "borderBottom": null,
        "locked": true,
        "textIndent": 0,
        "wordWrap": true,
        "name": "__builtInStyle12",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": "Background 1 -15",
        "foreColor": "#000000",
        "hAlign": 1,
        "vAlign": 1,
        "font": "normal bold 12px Calibri",
        "formatter": "0\\ \\F",
        "borderLeft": null,
        "borderTop": null,
        "borderRight": null,
        "borderBottom": null,
        "locked": true,
        "textIndent": 0,
        "wordWrap": true,
        "name": "__builtInStyle13",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": null,
        "foreColor": "#000000",
        "hAlign": 1,
        "vAlign": 1,
        "font": "normal normal 12px Calibri",
        "formatter": "0\\ %",
        "borderLeft": null,
        "borderTop": null,
        "borderRight": null,
        "borderBottom": null,
        "locked": true,
        "textIndent": 0,
        "wordWrap": true,
        "name": "__builtInStyle14",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": "Background 1 -15",
        "foreColor": "#000000",
        "hAlign": 1,
        "vAlign": 1,
        "font": "normal bold 12px Calibri",
        "formatter": "0\\ %",
        "borderLeft": null,
        "borderTop": null,
        "borderRight": null,
        "borderBottom": null,
        "locked": true,
        "textIndent": 0,
        "wordWrap": true,
        "name": "__builtInStyle15",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": null,
        "foreColor": "Text 1 0",
        "hAlign": 1,
        "vAlign": 1,
        "font": "normal normal 12px Calibri",
        "themeFont": "Body",
        "formatter": "0\\ %",
        "borderLeft": null,
        "borderTop": null,
        "borderRight": null,
        "borderBottom": null,
        "locked": true,
        "textIndent": 0,
        "wordWrap": false,
        "name": "__builtInStyle16",
        "diagonalDown": null,
        "diagonalUp": null
    }, {
        "backColor": "#82bc00",
        "foreColor": "#ffffff",
        "hAlign": 1,
        "vAlign": 1,
        "font": "normal bold 21.3px Calibri",
        "formatter": "General",
        "borderLeft": null,
        "borderTop": null,
        "borderRight": null,
        "borderBottom": null,
        "locked": true,
        "textIndent": 0,
        "wordWrap": true,
        "name": "__builtInStyle17",
        "diagonalDown": null,
        "diagonalUp": null
    }]
}];
</script>    
<div class="sample-tutorial">
<div id="ss" style="width:100%;height:380px"></div> 
</div>
