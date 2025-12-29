<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    .dropdown-tree>ul {
        overflow-y: auto;
        overflow-x: hidden;
        white-space: nowrap;
    }

    .dropdown-tree li {
        list-style: none
    }

    .dropdown-tree li>i {
        margin-left: 10px;
    }

    .dropdown-tree li:hover {
        background: #eee;
    }

    .dropdown-tree li:hover ul {
        background: white;
    }

    .dropdown-tree li:hover ul li:hover {
        background: #eee;
    }

    .dropdown-tree a {
        display: inline-block !important;
        padding: 3px 20px;
        clear: both;
        font-weight: 400;
        line-height: 1.42857143;
        color: #333;
        white-space: nowrap;
        text-decoration: none;
        background: transparent !important;
        position: relative;
    }

    .dropdown-tree .arrow {
        position: absolute;
        margin-left: -15px;
        top: 50%;
        transform: translateY(-50%);
    }

    /*RTL CSS*/
    .rtl-dropdown-tree {
        direction: rtl !important
    }

    .rtl-dropdown-tree>ul {
        right: 0;
        left: unset;
        text-align: right
    }

    .rtl-dropdown-tree .arrow {
        right: 6px
    }

    .rtl-dropdown-tree li>i {
        margin-left: 0;
        margin-right: 10px;
    }
    </style>
</head>

<body>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous">
    </script>
    <script src="https://josephskh.github.io/repos/dropdowntree/dropdowntree.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <div class="dropdown dropdown-tree" id="firstDropDownTree">
        <script>
        $(function() {
            var arr4 = [{
                    title: "A",
                    href: "#1",
                    dataAttrs: [{
                        title: "dataattr1",
                        data: "value1"
                    }, {
                        title: "dataattr2",
                        data: "value2"
                    }, {
                        title: "dataattr3",
                        data: "value3"
                    }]
                },
                {
                    title: "B",
                    href: "#2",
                    dataAttrs: [{
                        title: "dataattr4",
                        data: "value4"
                    }, {
                        title: "dataattr5",
                        data: "value5"
                    }, {
                        title: "dataattr6",
                        data: "value6"
                    }]
                },
                {
                    title: "C",
                    href: "#3",
                    dataAttrs: [{
                        title: "dataattr7",
                        data: "value7"
                    }, {
                        title: "dataattr8",
                        data: "value8"
                    }, {
                        title: "dataattr9",
                        data: "value9"
                    }]
                }
            ];
            var arr3 = [{
                    title: "P",
                    href: "#1",
                    dataAttrs: [{
                        title: "dataattr1",
                        data: "value1"
                    }, {
                        title: "dataattr2",
                        data: "value2"
                    }, {
                        title: "dataattr3",
                        data: "value3"
                    }]
                },
                {
                    title: "Q",
                    href: "#2",
                    dataAttrs: [{
                        title: "dataattr4",
                        data: "value4"
                    }, {
                        title: "dataattr5",
                        data: "value5"
                    }, {
                        title: "dataattr6",
                        data: "value6"
                    }],
                    data: arr4
                },
                {
                    title: "R",
                    href: "#3",
                    dataAttrs: [{
                        title: "dataattr7",
                        data: "value7"
                    }, {
                        title: "dataattr8",
                        data: "value8"
                    }, {
                        title: "dataattr9",
                        data: "value9"
                    }]
                }
            ];
            var options2 = {
                title: "Select",
                data: arr3,
                maxHeight: 3000,
                clickHandler: function(element) {
                    //gets clicked element parents
                    $("#firstDropDownTree2").SetTitle($(element).find("a").first().text());
                },
                closedArrow: '<i class="fa fa-caret-right" aria-hidden="true"></i>',
                openedArrow: '<i class="fa fa-caret-down" aria-hidden="true"></i>',
                multiSelect: true,
                selectChildren: true
            }
            $("#firstDropDownTree").DropDownTree(options2);
        });
        </script>
</body>

</html>