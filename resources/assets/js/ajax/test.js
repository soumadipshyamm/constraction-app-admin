$(document).ready(function () {
    // Sample hierarchical data
    var data = [
        {
            id: "1",
            text: "Root Node",
            children: [
                {
                    id: "2",
                    text: "Child Node 1",
                    children: [
                        {
                            id: "3",
                            text: "Subchild Node 1",
                        },
                        {
                            id: "4",
                            text: "Subchild Node 2",
                        },
                    ],
                },
                {
                    id: "5",
                    text: "Child Node 2",
                },
            ],
        },
    ];

    $("#dropdown-tree").select2({
        data: data,
        templateResult: formatResult, // Custom rendering function
        templateSelection: formatResult, // Custom rendering function for selected item
    });

    // Custom rendering function
    function formatResult(node) {
        if (!node.id) {
            return node.text; // Root node or no data
        }

        var level = node.id.split("-").length - 1; // Calculate the level of indentation

        var padding = "&nbsp;&nbsp;&nbsp;".repeat(level); // Indentation using non-breaking spaces

        return padding + node.text;
    }
});
