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
class Renderer {

    private messageJSONText: string;
    private messageSpec: any;

    /*

     */
    public constructor(json: string) {
        this.messageJSONText = json;
    }

    /*
     * Generates HTML version of the email
     */
    public render(): string {
        var out = '';
        try {
            this.messageSpec = JSON.parse(this.messageJSONText);
        } catch (e) {
            throw 'Invalid JSON';
        }

        var skip = false;
        if (Array.isArray(this.messageSpec.rows)) {
            this.messageSpec.rows.forEach((row) => {
                if (!skip) {
                    try {
                        out += `<table class="row"><tr>${this.renderRow(row)}</tr></table>`;
                    } catch (e) {
                        out = '<div class="error">' + e + '</div>';
                        skip = true;
                    }
                }
            });


            return out;
        } else {
            throw 'Message specification does not contain a rows array';
        }

    }

    /*
     * Makes sure that the provided row object has all the required properties.
     * Returns true if valid, throws exception otherwise.
     */
    private static validateRow(row: any): boolean {
        if ((typeof row.columns != 'undefined') && (Array.isArray(row.columns))) {
            if ((row.columns.length > 3) || (row.columns.length < 1)) {
                throw 'column count should be between 1 and 3';
            } else {
                return true;
            }
        } else {
            throw 'Invalid or missing columns array in row specification.';
        }
    }

    /*
     * Checks the provided column object type and other fields required by the type.
     * Returns true if valid, throws exception otherwise.
     */
    private static validateColumn(col: any) {
        if (typeof col == 'object') {
            if (col.hasOwnProperty('type') &&
                ((col.type == 'text') || (col.type == 'image'))) {
                if ((col.type == 'text') && (!col.hasOwnProperty('text'))) throw 'Invalid Column Specification';
                if ((col.type == 'image') && (!col.hasOwnProperty('image_url'))) throw 'Invalid Column Specification';

            } else {
                throw 'Invalid Column Type';
            }
        } else {
            throw 'Invalid Column Specification';
        }
        return true;
    }

    /*
     * Generates HTML for the specified row.
     */
    private renderRow(row: any): string {
        var out = '';
        if (Renderer.validateRow(row)) {
            const columnCount = parseInt(row.columns.length);
            var i = 0;
            row.columns.forEach(function (col) {
                if (Renderer.validateColumn(col)) {
                    var el: EMailElement;

                    switch (col.type) {
                        case 'text':
                            el = new EmailText(col, i, columnCount);
                            break;

                        case'image':
                            el = new EMailImage(col, i, columnCount);

                            break;
                    }

                    out += el.render();


                }
                i++;
            });

            return out;
        }

    }


}

/*
 * This class is meant to be sub-classed by the different types of email elements.
 */
abstract class EMailElement {
    public spec: any;
    public total: number;
    public index: number;

    constructor(columnSpec: any, index: number, total: number) {
        this.spec = columnSpec;
        this.total = total;
        this.index = index;
    }

    /*
     * Generates a table cell with the correct CSS classes depending on its size and index. Then calls the renderContent
     * function of the subclass to get the cell content.
     * Returns a string of HTML for the table cell.
     */
    public render() {
        const colValue = 12 / this.total;
        const last = (this.total == this.index + 1);
        const first = (this.index == 0);

        let out = `<th class="small-${colValue} large-${colValue} ${ first ? 'first' : ''} ${ last ? 'last' : '' } columns">
            ${this.renderContent()}
        </th>`;

        if (last) out += '<th class="expander"></th>';
        return out;
    }

    /*
     * Subclasses should implement this function to return their content.
     */
    abstract renderContent(): string;
}

class EMailImage extends EMailElement {
    public renderContent() {
        return `<img src="${this.spec.image_url}">`;
    }
}

class EmailText extends EMailElement {
    public renderContent() {
        return this.spec.text;
    }
}

