<?php
/**
 * Widgets manager
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anemcs.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */

/**
 * Widgets manager
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anemcs.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */
class Widget {

    /**
     * Get all widgets in one array
     *
     * @return array
     */
    public function getAllWidgets() {
        $widgets = array();
        if ($handle = opendir('./widgets')) {
            while (false !== ($file = readdir($handle)))
                if ($file != "." && $file != ".." && $file != "index.html")
                    $widgets[] = $file;
            closedir($handle);
        }
        return $widgets;
    }

    /**
     * Include all widgets
     *
     * @global Database $db
     * @global User $user
     * @global Template $tpl
     * @global array $database
     */
    public function includeAllWidgets() {
        global $db, $user, $tpl, $database, $skin;
        $widgets = '';
        if ($handle = opendir('./widgets')) {
            while (false !== ($file = readdir($handle)))
                if ($file != "." && $file != ".." && $file != "index.html")
                    include './widgets/'.$file.'/index.php';
            closedir($handle);
        }
    }

    /**
     * Get Widgets to include
     *
     * @global Database $db
     * @global array $database
     * @global String $skin
     * @return String
     */
    public function getWidgetsJS() {
        global $db, $database, $skin;
        $widgetsarea = $db->query('SELECT widgetarea FROM '.$database['tbl_prefix'].'dev_themes WHERE name = ? AND type = ?', DBDriver::AARRAY, array($skin, 1));
        $widgetsname = '';
        $jssaving = '';
        $cwidgetsareas = is_array(unserialize($widgetsarea['widgetarea']));

        $i = 0;
        if($cwidgetsareas > 0) {
            foreach (unserialize($widgetsarea['widgetarea']) as $widgetarea) {
                $i++;
                $widgetsname .= ', #'.$widgetarea;
                $jssaving .= ' serialStr += \''.(($i > 1) ? ',' : '').'"'.$widgetarea.'":[\'; $("#'.$widgetarea.' li.widget").each(function(i, elm) { serialStr += (i > 0 ? "," : "") + "\"" + $(elm).children().children(\'h2\').attr(\'name\') + "\""; });';
                if($i > $cwidgetsareas)
                    $jssaving .= ' serialStr += \'],\';';
                else
                    $jssaving .= ' serialStr += \']\';';

            }
            $js = '<?php if(is_a($user, \'User\') && $user->isOnGroup(\'Administrator\') && isset($_GET[\'modifywidgets\'])){ ?>$("#widgetselector '.$widgetsname.'").dragsort({ dragSelector: "li > div", dragBetween: true,dragEnd: saveOrder });';
            $js .= '
                    function saveOrder() {
                            var serialStr = \'{\';';
            $js .= $jssaving;
            $js .= ' serialStr += \'}\';';
            $js .= '$("input[name=widgetsContent]").val(serialStr); };<?php } ?>';

            return $js;
        }
        return '';
    }
}
?>
