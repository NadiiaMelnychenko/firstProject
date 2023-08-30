function InlineHTMLElements() {
    return <>
        <p>HTML defines a long list of available inline tags, a complete list of which can be found on the <a
            href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element">Mozilla Developer Network</a>.</p>
        <ul>
            <li><strong>To bold text</strong>, use <code
                className="language-plaintext highlighter-rouge">&lt;strong&gt;</code>.
            </li>
            <li><em>To italicize text</em>, use <code
                className="language-plaintext highlighter-rouge">&lt;em&gt;</code>.
            </li>
            <li>Abbreviations, like <abbr title="HyperText Markup Language">HTML</abbr> should use <code
                className="language-plaintext highlighter-rouge">&lt;abbr&gt;</code>, with an optional <code
                className="language-plaintext highlighter-rouge">title</code> attribute for the full phrase.
            </li>
            <li>Citations, like <cite>— Mark Otto</cite>, should use <code
                className="language-plaintext highlighter-rouge">&lt;cite&gt;</code>.
            </li>
            <li>
                <del>Deleted</del>
                text should use <code
                className="language-plaintext highlighter-rouge">&lt;del&gt;</code> and <ins>inserted</ins> text
                should use <code className="language-plaintext highlighter-rouge">&lt;ins&gt;</code>.
            </li>
            <li>Superscript <sup>text</sup> uses <code
                className="language-plaintext highlighter-rouge">&lt;sup&gt;</code> and
                subscript <sub>text</sub> uses <code
                    className="language-plaintext highlighter-rouge">&lt;sub&gt;</code>.
            </li>
        </ul>
        <p>Most of these elements are styled by browsers with few modifications on our part.</p>
    </>
}

export default InlineHTMLElements;