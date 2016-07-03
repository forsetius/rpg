<?php
namespace Forseti\PagesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Forseti\AdminBundle\Entity\Group;
use Forseti\AdminBundle\Entity\User;
use Forseti\PagesBundle\Entity\Article;
use Forseti\PagesBundle\Entity\Attachment;
use Forseti\PagesBundle\Entity\Category;
use Forseti\PagesBundle\Entity\Filetype;
use Forseti\PagesBundle\Entity\Image;
use Forseti\PagesBundle\Entity\Licence;
use Forseti\AdminBundle\DataFixtures\ORM\AbstractLoadAccessData;

class LoadUserData extends AbstractLoadAccessData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // load Filetypes

        $filetypes = [
            'Archiwum ZIP'=>['file-archive-o', '#000', 'application/zip', ['zip']],
            'Archiwum TAR.GZ'=>['file-archive-o', '#a00', 'application/gzip', ['tar.gz']],
            'Audio MP3'=>['file-audio-o', '#000', 'audio/mpeg', ['mp3']],
            'Dokument HTML'=>['file-code-o', '#000', 'text/html', ['html', 'htm', 'mhtml']],
            'Dokument XML'=>['file-code-o', '#06a', 'text/xml', ['xml', 'xsl']],
            'Dokument YAML'=>['file-code-o', '#a06', '', ['yml', 'yaml']],
            'Dokument JSON'=>['file-code-o', '#60a', 'application/json', ['json', 'geojson']],
            'Kod SQL'=>['file-text-o', '#a60', 'application/sql', ['sql']],
            'Kod JS'=>['file-text-o', '#aa0', 'application/javascript', ['js']],
            'Kod CSS'=>['file-text-o', '#0aa', 'text/css', ['css']],
            'Kod PHP'=>['file-text-o', '#a0a', ' application/x-php', ['php', 'php4', 'php5', 'php7']],
            'Kod Pythona'=>['file-text-o', '#00a', '', ['py', 'pyc']],
            'Kod Ruby'=>['file-text-o', '#a00', '', ['rb']],
            'Skrypt powłoki'=>['file-text-o', '#0a0', '', ['sh']],
            'Dokument tekstowy'=>['file-text-o', '#000', 'text/plain', ['txt']],
            'Dokument Worda'=>['file-code-o', '#000', 'application/vnd.ms-word.document.macroEnabled.12', ['doc, docx']],
            'Dokument OpenOffice/LibreOffice'=>['file-code-o', '#000', 'pplication/vnd.oasis.opendocument.text', ['odf']],
            'Arkusz OpenOffice/LibreOffice'=>['file-code-o', '#000', 'application/vnd.oasis.opendocument.spreadsheet', ['odf']],
            'Arkusz Excela'=>['file-code-o', '#0a0', 'application/vnd.ms-excel', ['xls', 'xlsx', 'xlsm', 'xlsb']],
            'Plik CSV'=>['file-excel-o', '#000', 'ext/csv', ['csv', 'tsv']],
            'Dokument PDF'=>['file-pdf-o', '#a00', 'application/pdf', ['pdf']],
            'Obraz JPG'=>['file-image-o', '#a0a', 'image/jpeg', ['jpg', 'jpeg']],
            'Obraz GIF'=>['file-image-o', '#0aa', 'image/gif', ['gif']],
            'Obraz PNG'=>['file-image-o', '#0a0', 'image/png', ['png']],
            'Sygnatura PGP'=>['certificate', '#00a', 'application/pgp-signature', ['asc', 'sig']]
        ];
        foreach ($filetypes as $key=>$data) {
            $object = $this->register(new Filetype());
            $object->setName($key);
            $object->setIcon($data[0]);
            $object->setColor($data[1]);
            $object->setContentType($data[2]);
            $object->setExtensions($data[3]);
        }

        // load Licences
        $licMit = $this->register(new Licence());
        $licMit->setName('MIT');
        $licMit->setLongname('The MIT License');
        $licMit->setUrl('https://opensource.org/licenses/MIT');

        $licCcByNcSa = $this->register(new Licence());
        $licCcByNcSa->setName('CC-BY-NC-SA');
        $licCcByNcSa->setLongname('Creative Commons Uznanie Autorstwa – Użycie Niekomercyjne – Na Tych Samych Warunkach');
        $licCcByNcSa->setUrl('https://creativecommons.org/licenses/by-nc-sa/4.0');

        $licCcByNc = $this->register(new Licence());
        $licCcByNc->setName('CC-BY-NC');
        $licCcByNc->setLongname('Creative Commons Uznanie Autorstwa – Użycie Niekomercyjne');
        $licCcByNc->setUrl('https://creativecommons.org/licenses/by-nc/4.0');

        $licCcBySa = $this->register(new Licence());
        $licCcBySa->setName('CC-BY-SA');
        $licCcBySa->setLongname('Creative Commons Uznanie Autorstwa – Na Tych Samych Warunkach');
        $licCcBySa->setUrl('https://creativecommons.org/licenses/by-sa/4.0');

        $licCcBy = $this->register(new Licence());
        $licCcBy->setName('CC-BY');
        $licCcBy->setLongname('Creative Commons Uznanie Autorstwa');
        $licCcBy->setUrl('https://creativecommons.org/licenses/by/4.0');

        // load Images
        $imgCatOm = $this->register(new Image());
        $imgCatOm->setTitle('Tunnel of light');
        $imgCatOm->setName('oceany-mroku-card');
        $imgCatOm->setTemplate('image-licenced');
        $imgCatOm->setPageOrder(1);
        $imgCatOm->setFilenameMain('card-om.jpg');
        $imgCatOm->setFilenameThumb('card-om-th.jpg');
        $imgCatOm->setSize(3000000);
        $imgCatOm->setMetaTitle('Oceany Mroku');
        $imgCatOm->setMetaDesc('Oceany Mroku - mroczne urban fantasy');
        $imgCatOm->setMetaKeywords('oceany mroku mrok rpg urban fantasy');
        $imgCatOm->setLicence($licCcByNcSa);
        $imgCatOm->setAttribution('Ktoś z Wikipedii');

        $imgCatEp = $this->register(new Image());
        $imgCatEp->setTitle('Spacewalk');
        $imgCatEp->setName('eclipse-phase-card');
        $imgCatEp->setTemplate('image-licenced');
        $imgCatEp->setPageOrder(2);
        $imgCatEp->setFilenameMain('card-ep.jpg');
        $imgCatEp->setFilenameThumb('card-ep-th.jpg');
        $imgCatEp->setSize(2000000);
        $imgCatEp->setMetaTitle('Eclipse Phase');
        $imgCatEp->setMetaDesc('Eclipse Phase - transhumanizm po upadku Ziemi');
        $imgCatEp->setMetaKeywords('eclipse phase rpg sci-fi horror konspiracja postapo');
        $imgCatEp->setLicence($licCcByNc);
        $imgCatEp->setAttribution('Posthuman Studios');

        $imgCatMta = $this->register(new Image());
        $imgCatMta->setTitle('Purple curtain');
        $imgCatMta->setName('mage-the-ascansion-card');
        $imgCatMta->setTemplate('image-licenced');
        $imgCatMta->setPageOrder(3);
        $imgCatMta->setFilenameMain('card-mta.jpg');
        $imgCatMta->setFilenameThumb('card-mta-th.jpg');
        $imgCatMta->setSize(2000000);
        $imgCatMta->setMetaTitle('Mage: the Ascension');
        $imgCatMta->setMetaDesc('Mage: the Ascension - magiczna wojna o życie, wszechświat i całą resztę');
        $imgCatMta->setMetaKeywords('mage ascension mag wstąpienie rpg');
        $imgCatMta->setLicence($licCcByNcSa);
        $imgCatMta->setAttribution('Onyx Path');

        // load Attachments
        $attchEpCelestia = $this->register(new Attachment());
        $attchEpCelestia->setName('eclipse-phase-celestia-locations');
        $attchEpCelestia->setTitle('Eclipse Phase locations for Celestia');
        $attchEpCelestia->setContent('Instrukcja');
        $attchEpCelestia->setFilename('ep-celestia-loc-1.0.3.zip');
        $attchEpCelestia->setSize(6000000);
//        $attchEpCelestia->setType($manager->getRepository(User::class)->findOneBy(['name'=>'Archiwum ZIP']));
        $attchEpCelestia->setLicence($licCcByNcSa);
        $attchEpCelestia->setAttribution('Forseti');
        $attchEpCelestia->setPageOrder(1);
        $attchEpCelestia->setTemplate('attch');
        $attchEpCelestia->setMetaTitle($attchEpCelestia->getTitle());
        $attchEpCelestia->setMetaDesc($attchEpCelestia->getTitle());
        $attchEpCelestia->setMetaKeywords('eclipse phase celestia');

        // load Categories
        $catRoot = $this->register(new Category());
        $catRoot->setName('root');
        $catRoot->setTitle('Główna');
        $catRoot->setContent('');
        $catRoot->setParent();
        $catRoot->setBreadcrumbs(['']);
        $catRoot->setMetaDesc('');
        $catRoot->setMetaKeywords('');
        $catRoot->setMetaTitle($catRoot->getTitle());
        $catRoot->setPageOrder(0); // FIXME
        $catRoot->setTemplate('category');

        $catOm = $this->register(new Category());
        $catOm->setName('oceany-mroku');
        $catOm->setTitle('Oceany Mroku');
        $catOm->setContent('<p>Ciemność widzę! Ciemność!</p>');
        $catOm->setParent($catRoot);
        $catOm->setBreadcrumbs(['root']); // FIXME
        $catOm->setFrontImage($imgCatOm);
        $catOm->setMetaDesc('Ciemność widzę! Ciemność!');
        $catOm->setMetaKeywords('');
        $catOm->setMetaTitle($catOm->getTitle());
        $catOm->setPageOrder(1); // FIXME
        $catOm->setTemplate('category');

        $catEp = $this->register(new Category());
        $catEp->setName('eclipse-phase');
        $catEp->setTitle('Eclipse Phase');
        $catEp->setContent('<p>Transludzka przyszłość po upadku Ziemi</p>');
        $catEp->setParent($catRoot);
        $catEp->setBreadcrumbs(['root']); // FIXME
        $catEp->setFrontImage($imgCatEp);
        $catEp->setMetaDesc('Transludzka przyszłość po upadku Ziemi');
        $catEp->setMetaKeywords('');
        $catEp->setMetaTitle($catEp->getTitle());
        $catEp->setPageOrder(2); // FIXME
        $catEp->setTemplate('category');

        // load Articles
        
        $artHome = $this->register(new Article());
        $artHome->setName('homepage');
        $artHome->setTitle('Forseti: abstract worlds');
        $artHome->setLead('RPG - Gry fabularne');
        $artHome->setContent(<<<EOT
<p>Drogi Marszałku, Wysoka Izbo. PKB rośnie. Nie zapominajmy jednak, że dokończenie aktualnych projektów spełnia ważne z szerokim aktywem rozszerza nam efekt obecnej sytuacji. Wagi i określenia systemu finansowego zabezpiecza udział szerokiej grupie w tym zakresie ukazuje nam efekt obecnej sytuacji. Koleżanki i określenia systemu szkolenia kadr powoduje docenianie wag systemu powszechnego uczestnictwa. Wyższe założenie ideowe, a także konsultacja z dotychczasowymi zasadami systemu szkolenia kadr zmusza nas do tej sprawy spełnia ważne zadanie w przyszłościowe rozwiązania pomaga w określaniu dalszych kierunków postępowego wychowania. PKB rośnie. Różnorakie i określenia form działalności wymaga sprecyzowania i określenia systemu szkolenia kadry odpowiadającego potrzebom.</p>
EOT
);
        $artHome->setPageOrder(0);
        $artHome->setTemplate('homepage');
        $artHome->setMetaTitle($artHome->getTitle() .' | '. $artHome->getLead());
        $artHome->setAuthor($manager->getRepository(User::class)->findOneBy(['username'=>'root']));
        $artHome->setMetaKeywords('Forseti');
        $artHome->setMetaDesc('Opis');
        $artHome->setCategory($catRoot);
        $artHome->addImage($imgCatEp);
        $artHome->addImage($imgCatMta);
        $artHome->addAttachment($attchEpCelestia);

        // load Comments

        // load Groups

        $groupAdmin = $this->register(new Group());
        $groupAdmin->setName('CMS Admin');
        $groupAdmin->setColor('#dddd00');
        $groupAdmin->setRoles(['ROLE_ARTICLE_ALL', 'ROLE_ATTACHMENT_ALL', 'ROLE_CATEGORY_ALL', 'ROLE_COMMENT_ALL', 'ROLE_FILETYPE_ALL', 'ROLE_IMAGE_ALL', 'ROLE_LICENCE_ALL', 'ROLE_TAG_ALL']);

        $groupAuthor = $this->register(new Group());
        $groupAuthor->setName('Author');
        $groupAuthor->setColor('#009900');
        $groupAuthor->setRoles(['ROLE_ARTICLE_OWN', 'ROLE_ATTACHMENT_OWN', 'ROLE_CATEGORY_SEE', 'ROLE_COMMENT_OWN', 'ROLE_FILETYPE_SEE', 'ROLE_IMAGE_OWN', 'ROLE_LICENCE_SEE', 'ROLE_TAG_SEE']);

        $groupVisitor = $this->register($manager->getRepository(Group::class)->findOneBy(['name'=>'Visitor']));
        $groupVisitor->addRole('ROLE_ARTICLE_SEE')->addRole('ROLE_ATTACHMENT_SEE')->addRole('ROLE_CATEGORY_SEE')->addRole('ROLE_COMMENT_SEE')->addRole('ROLE_FILETYPE_SEE')->addRole('ROLE_IMAGE_SEE')->addRole('ROLE_LICENCE_SEE')->addRole('ROLE_TAG_SEE');

        // load Users

        $userSuperAdmin = $this->register($manager->getRepository(User::class)->findOneBy(['username'=>'root']));
        $userSuperAdmin->addGroup($groupAdmin);

        $userCmsAdmin = $this->register(new User());
        $userCmsAdmin->setUsername('cmsadmin');
        $userCmsAdmin->setPlainPassword('password');
        $userCmsAdmin->setEmail('exe@gm.com');
        $userCmsAdmin->setColor('#999900');
        $userCmsAdmin->addGroup($groupAdmin);

        $userAuthor = $this->register(new User());
        $userAuthor->setUsername('author');
        $userAuthor->setPlainPassword('password');
        $userAuthor->setEmail('ex1e@gm.com');
        $userAuthor->setColor('#009900');
        $userAuthor->addGroup($groupAuthor);

        $this->flush($manager);
    }
    
    public function getOrder()
    {
        return 10;
    }
}
