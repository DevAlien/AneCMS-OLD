<?php
/**
 * Create an RSS 2.0 xml feed.
 *
 * @package ANECMS
 * @category   XML, RSS
 * @author     Costin Trifan <costintrifan@yahoo.com>
 * @copyright  2009 Costin Trifan
 * @license    http://en.wikipedia.org/wiki/MIT_License   MIT License
 * @version    1.0
 *
 */

/**
 * Create an RSS 2.0 xml feed.
 *
 * @category   XML, RSS
 * @author     Costin Trifan <costintrifan@yahoo.com>
 * @copyright  2009 Costin Trifan
 * @license    http://en.wikipedia.org/wiki/MIT_License   MIT License
 * @version    1.0
 *
 */
class RssWriter {
    private function __clone() {

    }

    /**
     * Start the xml document
     *
     * @param string $xmlStylesheetFile  The path to the associated xml stylesheet file.
     * @return void
     */
    public function __construct( $xmlStylesheetFile = '' ) {
        self::$_doc = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>"."\n";
        if (strlen($xmlStylesheetFile) > 0)
            self::$_doc .= '<?xml-stylesheet type="text/xsl" href="../'.$xmlStylesheetFile.'"?>';

        self::$_doc .= '<rss version="2.0"'."\n\t";
    }

    /**
     * Holds the feed's content
     * @type string
     */
    protected static $_doc = '';

    /**
     * Add xml namespaces
     *
     * @param array $xmlns  The list of namespaces to add to the document. (As an associative array: 'namespace-name' => 'namespace url')
     * @return void
     */
    final public function AddNamespaces( $xmlns = array() ) {
        if (count($xmlns) < 1) {
            self::$_doc .= '>'; // close tag
            return;
        }

        foreach ($xmlns as $name=>$value)
            self::$_doc .= " xmlns:$name=\"$value\"\n\t";

        self::$_doc .= '>'; // close tag
    }

    /**
     * Add channel's tags
     * @return void
     */
    final public function AddChannelTags( array $channelTags ) {
        self::$_doc .= "<channel>\n";
        if (count($channelTags) > 0) {
            foreach ($channelTags as $tagName=>$tagValue)
                self::$_doc .= "<$tagName>$tagValue</$tagName>\n";
        }
    }
    final public function addAtomLink( $link){
        self::$_doc .= '<atom:link href="'.urlencode('http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]).'" rel="self" type="application/rss+xml" />';
    }
    /**
     * Add channel items
     * @return void
     */
    final public function AddItems( $itemTags = array() ) {
        if (count($itemTags) > 0) {
            foreach ($itemTags as $entries) {
                self::$_doc .= "<item>";

                foreach ($entries as $tagName=>$tagValue)
                    self::$_doc .= "<$tagName>$tagValue</$tagName>";

                self::$_doc .= "</item>\n";
            }
        }
    }

    /**
     * Write the xml document's closing tags
     * @return void
     */
    final public function EndDocument() {
        self::$_doc .= '</channel></rss>';
    }

    /**
     * Display the feed's content
     * @return void
     */
    final public function Display() {
        echo self::$_doc;
    }

}
?>