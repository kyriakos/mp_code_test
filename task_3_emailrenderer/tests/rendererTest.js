var assert = chai.assert;
var expect = chai.expect;

// Sample json text for testing
var jsonText = '{"rows": [ {"columns": [{"type": "image","image_url": "http://image.domain.ext/image.jpg"},{'
jsonText += '"type": "text",';
jsonText += '"text": "Hello World"}]},{"columns": [{"type": "text","text": "Left column text"';
jsonText += '},{"type": "text","text": "Right column text"}]}]}';

describe('Renderer.validateRow', function () {
  it('throw exception if more than 3 columns are specified', function () {
    expect(Renderer.validateRow.bind(Renderer, { columns: [ 1, 2, 3, 4 ] })).to.throw('column count should be between 1 and 3');
  });

  it('throw exception if less than 0 columns are specified', function () {
    expect(Renderer.validateRow.bind(Renderer, { columns: [] })).to.throw('column count should be between 1 and 3');
  });

  it('throw exception if no columns key is found in row', function () {
    expect(Renderer.validateRow.bind(Renderer, {})).to.throw('Invalid or missing columns array in row specification.');
  });

  it('valid row should return true', function () {
    assert.isTrue(
      Renderer.validateRow({
        "columns": [
          {
            "type": "text",
            "text": "Left column text"
          },
          {
            "type": "text",
            "text": "Right column text"
          }
        ]
      })
    );
  });

});

describe('Renderer.validateColumn', function () {
  it('throw exception if text column has no text', function () {
    expect(Renderer.validateColumn.bind(Renderer, {
      "type": "text",
      "image_url": "..."
    })).to.throw('Invalid Column Specification');
  });

  it('throw exception if image column has no image_url', function () {
    expect(Renderer.validateColumn.bind(Renderer, {
      "type": "image",
      "text": "..."
    })).to.throw('Invalid Column Specification');
  });

  it('throw exception if no column type exists', function () {
    expect(Renderer.validateColumn.bind(Renderer, {})).to.throw('Invalid Column Type');
  });

  it('return true if valid column is used', function () {
    assert.isTrue(Renderer.validateColumn({
      "type": "text",
      "text": "some text"
    }));
  });

});

describe('Renderer.Render', function () {
  it('throw exception if json has no rows', function () {
    var r = new Renderer('{}');
    expect(r.render.bind(r)).to.throw('Message specification does not contain a rows array');
  });

  it('throw exception if input cannot be parsed as json', function () {
    var r = new Renderer('not_json');
    expect(r.render.bind(r)).to.throw('Invalid JSON');
  })

  it('output contains small-6 when two columns are rendered', function () {
    var r = new Renderer(jsonText);
    assert.include(r.render(), 'small-6');
    assert.include(r.render(), '<img src="http://image.domain.ext/image.jpg">');
    assert.include(r.render(), 'Hello World');
  });

});

describe('EMailElement', function () {
  it('Text element is rendered correctly', function () {
    var t = new EmailText({
        "type": "text",
        "text": "Hello World"
      }, 1, 3
    );

    var rendered = t.render();
    assert.isString(rendered);
    assert.equal(t.renderContent(), 'Hello World');
    assert.include(rendered, 'small-4');

    // since this is the column element it should not include "first" or "last" classes
    assert.notInclude(rendered, 'first');
    assert.notInclude(rendered, 'last');
  });

  it('Image element is rendered correctly', function () {
    var t = new EMailImage({
        "type": "text",
        "image_url": "http://image.domain.ext/image.jpg"
      }, 1, 2
    );

    var rendered = t.render();
    assert.isString(rendered);
    assert.equal(t.renderContent(), '<img src="http://image.domain.ext/image.jpg">');
    assert.include(rendered, 'small-6');
    assert.include(rendered, 'last');

    console.log(rendered);
  });
});
