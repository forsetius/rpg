<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    
    const IMAGES = 1;
    const SUBPAGES = 2;
    const ATTACHMENTS = 4;
    const LINKS = 8;
    
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        $vars = array(
            'mainSlides'=>array(
                array('src'=>'/img/slide1.jpg','alt'=>'slide1','title'=>'Eclipse Phase','text'=>'Akcja Eclipse Phase rozgrywa się za jakieś 120 lat, po wojnie, która zgładziła ponad 95% ludzkości. Ziemia leży w ruinie, większość cudów cywilizacji została zniszczona, państwa upadły. Niedobitki ludzi rozproszyły się po całym Układzie Słonecznym, a nawet poza niego. '),
                array('src'=>'/img/slide2.jpg','alt'=>'slide2','title'=>'Mag: Wstąpienie','text'=>'Istotą tej gry jest walka o narzucenie ludzkości własnej wizji świata i prawideł nim rządzących. Gra zakłada, że całą tą rzeczywistością nie rządzą bynajmniej jakieś stałe, obiektywne i niezmienne prawa. Przeciwnie, to istoty zamieszkujące świat ustalają prawa w nim panujące.'),
                array('src'=>'/img/slide3.jpg','alt'=>'slide3','title'=>'Dungeons & Dragons 5e','text'=>'Piąta edycja Dungeons & Dragons jest najłatwiejszą i najbardziej epicką ever.')
            ),
            'subs'=>array(
                array('name'=>'oceany_mroku','title'=>'Oceany Mroku','lead'=>'<p>Ciemność widzę! Ciemność!</p>', 'image_card'=>'/img/card-om.jpg', 'links'=>array(
                    array('href'=>'#', 'text'=>'UniMechanika', 'type'=>'mechanika', 'class'=>'colorful emphasis'),
                    array('href'=>'#', 'text'=>'Departament X', 'type'=>'setting', 'class'=>'colorful'),
                    array('href'=>'#', 'text'=>'Polska Nieumarła', 'type'=>'setting', 'class'=>'colorful'),
                )),
                array('name'=>'eclipse_phase','title'=>'Eclipse Phase','lead'=>'<p>Transludzka przyszłość po upadku Ziemi</p>', 'image_card'=>'/img/card-ep.jpg', 'links'=>array(
                    array('href'=>'#', 'text'=>'Encyklopedia', 'type'=>'dział', 'class'=>'colorful'),
                    array('href'=>'#', 'text'=>'Generator scenariuszy', 'type'=>'generator', 'class'=>'colorful'),
                )),
                array('name'=>'mage_ascension','title'=>'Mage: the Ascension','lead'=>'<p>Metafizyczna walka o rząd dusz i kształt rzeczywistości</p>', 'image_card'=>'/img/card-mta.jpg', 'links'=>array(
                    array('href'=>'#', 'text'=>'Tradycje', 'type'=>'dział', 'class'=>'colorful'),
                    array('href'=>'#', 'text'=>'Wiedza', 'type'=>'dział', 'class'=>'colorful'),
                )),
                array('name'=>'dnd5','title'=>'Dungeons & Dragons 5e','lead'=>'<p>Klasyczne sword&sorcery w wersji epickiej</p>', 'image_card'=>'/img/card-dnd.jpg', 'links'=>array(
                    array('href'=>'#', 'text'=>'Psionika', 'type'=>'dział', 'class'=>'colorful'),
                    array('href'=>'#', 'text'=>'Archetypy', 'type'=>'dział', 'class'=>'colorful'),
                    array('href'=>'#', 'text'=>'Pochodzenie', 'type'=>'dział', 'class'=>'colorful'),
                )),
            )
        );
        
        return $this->render('default/index.html.twig', [
            '_locale' => $request->getLocale(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    /**
     * @Route("/{slug}/{locale}", name="show_page", )
     */
    public function showAction(Request $request, $slug, $locale)
    {

    }
    
    protected function getPage(Request $request, $vars=array()) {
        $locale = strtoupper($request->getLocale());
    
        $sql = <<<SQL
        SELECT id, name, parentId, level, page_order,
               breadcrumbs, deps, template, shown, css_class,
               title$locale as title,
               lead$locale as lead,
               content$locale as content,
               meta_title$locale as meta_title,
               meta_desc$locale as meta_desc,
               meta_keywords$locale as meta_keywords
        FROM pages_page
        WHERE name = ?
SQL;
        //$page = $app['db']->fetchAssoc($sql, array($name));
    
        if (empty($page)) {
            // TODO wyjątek? 404?
        }
        $imgs = array();
        if($page['deps'] & DefaultController::IMAGES) {
            $sql = "SELECT * FROM pages_images WHERE pageId = ?";
            $imgs = $app['db']->fetchAssoc($sql, array($page['id']));
        }
    
        $subs = array();
        if($page['deps'] & DefaultController::SUBPAGES) {
            $sql = "SELECT * FROM pages_page WHERE parent = ? ORDER BY page_order";
            $subs = $app['db']->fetchAssoc($sql, array($page['id']));
        }
    
        $atts = array();
        if($page['deps'] & DefaultController::ATTACHMENTS) {
            $sql = <<<SQL
            SELECT
                a.*, at.icon
            FROM
                `pages_page_attachment` as pa,
                `pages_attachment` as a,
                `pages_attachment_type` as at
            WHERE
                pa.pageId = ? AND
                pa.attachmentId = a.id AND
                a.typeId = at.id
            ORDER BY
                a.title$locale
SQL;
            $atts = $app['db']->fetchAssoc($sql, array($page['id']));
        }
    
        $links = array();
        if($page['deps'] & DefaultController::LINKS) {
            // TODO
        }
    
        return $app['twig']->render($page['template'] .'.twig', $vars + array(
            'page' => $page,
            'imgs' => $imgs,
            'subs' => $subs,
            'atts' => $atts,
            'links'=> $links
        ));
    }
}
