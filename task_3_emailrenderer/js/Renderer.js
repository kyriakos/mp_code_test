var __extends = (this && this.__extends) || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
};
/*
 * This is the main class for rendering emails from a JSON definition.
 * How to use:
 *
 * Instantiate the class with the json in textual form as a parameter
 *
 * var r = new Renderer(text);
 *
 * and call its render method to generate HTML based on the provided JSON:
 *
 * var html =  r.render();
 *
 * If the JSON representation is invalid or doesn't follow the specification an exception will be thrown.
 */
var Renderer = (function () {
    /*

     */
    function Renderer(json) {
        this.messageJSONText = json;
    }
    /*
     * Generates HTML version of the email
     */
    Renderer.prototype.render = function () {
        var _this = this;
        var out = '';
        try {
            this.messageSpec = JSON.parse(this.messageJSONText);
        }
        catch (e) {
            throw 'Invalid JSON';
        }
        var skip = false;
        if (Array.isArray(this.messageSpec.rows)) {
            this.messageSpec.rows.forEach(function (row) {
                if (!skip) {
                    try {
                        out += "<table class=\"row\"><tr>" + _this.renderRow(row) + "</tr></table>";
                    }
                    catch (e) {
                        out = '<div class="error">' + e + '</div>';
                        skip = true;
                    }
                }
            });
            return out;
        }
        else {
            throw 'Message specification does not contain a rows array';
        }
    };
    /*
     * Makes sure that the provided row object has all the required properties.
     * Returns true if valid, throws exception otherwise.
     */
    Renderer.validateRow = function (row) {
        if ((typeof row.columns != 'undefined') && (Array.isArray(row.columns))) {
            if ((row.columns.length > 3) || (row.columns.length < 1)) {
                throw 'column count should be between 1 and 3';
            }
            else {
                return true;
            }
        }
        else {
            throw 'Invalid or missing columns array in row specification.';
        }
    };
    /*
     * Checks the provided column object type and other fields required by the type.
     * Returns true if valid, throws exception otherwise.
     */
    Renderer.validateColumn = function (col) {
        if (typeof col == 'object') {
            if (col.hasOwnProperty('type') &&
                ((col.type == 'text') || (col.type == 'image'))) {
                if ((col.type == 'text') && (!col.hasOwnProperty('text')))
                    throw 'Invalid Column Specification';
                if ((col.type == 'image') && (!col.hasOwnProperty('image_url')))
                    throw 'Invalid Column Specification';
            }
            else {
                throw 'Invalid Column Type';
            }
        }
        else {
            throw 'Invalid Column Specification';
        }
        return true;
    };
    /*
     * Generates HTML for the specified row.
     */
    Renderer.prototype.renderRow = function (row) {
        var out = '';
        if (Renderer.validateRow(row)) {
            var columnCount_1 = parseInt(row.columns.length);
            var i = 0;
            row.columns.forEach(function (col) {
                if (Renderer.validateColumn(col)) {
                    var el;
                    switch (col.type) {
                        case 'text':
                            el = new EmailText(col, i, columnCount_1);
                            break;
                        case 'image':
                            el = new EMailImage(col, i, columnCount_1);
                            break;
                    }
                    out += el.render();
                }
                i++;
            });
            return out;
        }
    };
    return Renderer;
}());
/*
 * This class is meant to be sub-classed by the different types of email elements.
 */
var EMailElement = (function () {
    function EMailElement(columnSpec, index, total) {
        this.spec = columnSpec;
        this.total = total;
        this.index = index;
    }
    /*
     * Generates a table cell with the correct CSS classes depending on its size and index. Then calls the renderContent
     * function of the subclass to get the cell content.
     * Returns a string of HTML for the table cell.
     */
    EMailElement.prototype.render = function () {
        var colValue = 12 / this.total;
        var last = (this.total == this.index + 1);
        var first = (this.index == 0);
        var out = "<th class=\"small-" + colValue + " large-" + colValue + " " + (first ? 'first' : '') + " " + (last ? 'last' : '') + " columns\">\n            " + this.renderContent() + "\n        </th>";
        if (last)
            out += '<th class="expander"></th>';
        return out;
    };
    return EMailElement;
}());
var EMailImage = (function (_super) {
    __extends(EMailImage, _super);
    function EMailImage() {
        _super.apply(this, arguments);
    }
    EMailImage.prototype.renderContent = function () {
        return "<img src=\"" + this.spec.image_url + "\">";
    };
    return EMailImage;
}(EMailElement));
var EmailText = (function (_super) {
    __extends(EmailText, _super);
    function EmailText() {
        _super.apply(this, arguments);
    }
    EmailText.prototype.renderContent = function () {
        return this.spec.text;
    };
    return EmailText;
}(EMailElement));
//# sourceMappingURL=Renderer.js.map