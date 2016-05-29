<?php
namespace Forseti\PagesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Forseti\AdminBundle\Entity\Group;
use Forseti\AdminBundle\Entity\User;
use Forseti\PagesBundle\Entity\Category;
use Forseti\PagesBundle\Entity\Filetype;
use Forseti\PagesBundle\Entity\Licence;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // load Filetypes

        $filetypes = [
            'Archiwum ZIP'=>['file-archive-o', '#000', 'application/zip', 'zip'],
            'Archiwum TAR.GZ'=>['file-archive-o', '#a00', 'application/gzip', 'tar.gz'],
            'Audio MP3'=>['file-audio-o', '#000', 'audio/mpeg', 'mp3'],
            'Dokument HTML'=>['file-code-o', '#000', 'text/html', ['html', 'htm', 'mhtml']],
            'Dokument XML'=>['file-code-o', '#06a', 'text/xml', ['xml', 'xsl']],
            'Dokument YAML'=>['file-code-o', '#a06', '', ['yml', 'yaml']],
            'Dokument JSON'=>['file-code-o', '#60a', 'application/json', ['json', 'geojson']],
            'Kod SQL'=>['file-text-o', '#a60', 'application/sql', 'sql'],
            'Kod JS'=>['file-text-o', '#aa0', 'application/javascript', 'js'],
            'Kod CSS'=>['file-text-o', '#0aa', 'text/css', 'css'],
            'Kod PHP'=>['file-text-o', '#a0a', ' application/x-php', 'php', 'php4', 'php5', 'php7'],
            'Kod Pythona'=>['file-text-o', '#00a', '', 'py', 'pyc'],
            'Kod Ruby'=>['file-text-o', '#a00', '', 'rb'],
            'Skrypt powłoki'=>['file-text-o', '#0a0', '', 'sh'],
            'Dokument tekstowy'=>['file-text-o', '#000', 'text/plain', 'txt'],
            'Dokument Worda'=>['file-code-o', '#000', 'application/vnd.ms-word.document.macroEnabled.12', ['doc, docx']],
            'Dokument OpenOffice/LibreOffice'=>['file-code-o', '#000', 'pplication/vnd.oasis.opendocument.text', 'odf'],
            'Arkusz OpenOffice/LibreOffice'=>['file-code-o', '#000', 'application/vnd.oasis.opendocument.spreadsheet', 'odf'],
            'Arkusz Excela'=>['file-code-o', '#0a0', 'application/vnd.ms-excel', ['xls', 'xlsx', 'xlsm', 'xlsb']],
            'Plik CSV'=>['file-excel-o', '#000', 'ext/csv', ['csv', 'tsv']],
            'Dokument PDF'=>['file-pdf-o', '#a00', 'application/pdf', 'pdf'],
            'Obraz JPG'=>['file-image-o', '#a0a', 'image/jpeg', ['jpg', 'jpeg']],
            'Obraz GIF'=>['file-image-o', '#0aa', 'image/gif', 'gif'],
            'Obraz PNG'=>['file-image-o', '#0a0', 'image/png', 'png'],
            'Sygnatura PGP'=>['certificate', '#00a', 'application/pgp-signature', ['asc', 'sig']]
        ];
        foreach ($filetypes as $key=>$data) {
            $object = new Filetype();
            $object->setName($key);
            $object->setIcon($data[0]);
            $object->setColor($data[1]);
            $object->setContentType($data[2]);
            $object->setExtensions($data[3]);
            $manager->persist($object);
        }

        // load Licences
        $licMit = new Licence();
        $licMit->setName('MIT');
        $licMit->setLongname('The MIT License');
        $licMit->setUrl('https://opensource.org/licenses/MIT');

        $licCcByNcSa = new Licence();
        $licCcByNcSa->setName('CC-BY-NC-SA');
        $licCcByNcSa->setLongname('Creative Commons Uznanie Autorstwa – Użycie Niekomercyjne – Na Tych Samych Warunkach');
        $licCcByNcSa->setUrl('https://creativecommons.org/licenses/by-nc-sa/4.0');

        $licCcByNc = new Licence();
        $licCcByNc->setName('CC-BY-NC');
        $licCcByNc->setLongname('Creative Commons Uznanie Autorstwa – Użycie Niekomercyjne');
        $licCcByNc->setUrl('https://creativecommons.org/licenses/by-nc/4.0');

        $licCcBySa = new Licence();
        $licCcBySa->setName('CC-BY-SA');
        $licCcBySa->setLongname('Creative Commons Uznanie Autorstwa – Na Tych Samych Warunkach');
        $licCcBySa->setUrl('https://creativecommons.org/licenses/by-sa/4.0');

        $licCcBy = new Licence();
        $licCcBy->setName('CC-BY');
        $licCcBy->setLongname('Creative Commons Uznanie Autorstwa');
        $licCcBy->setUrl('https://creativecommons.org/licenses/by/4.0');

        // load Categories
        $catRoot = new Category();
        $catRoot->setName('root');
        $catRoot->setTitle('Główna');
        $catRoot->setContent('');
        $catRoot->setParent($catRoot);
        $catRoot->setBreadcrumbs([]); // FIXME
        $catRoot->setFrontImage('');
        $catRoot->setMetaDesc('');
        $catRoot->setMetaKeywords('');
        $catRoot->setMetaTitle($catRoot->getTitle());
        $catRoot->setPageOrder(0); // FIXME
        $catRoot->setTemplate('category');

        $catOm = new Category();
        $catOm->setName('oceany-mroku');
        $catOm->setTitle('Oceany Mroku');
        $catOm->setContent('<p>Ciemność widzę! Ciemność!</p>');
        $catOm->setParent($catRoot);
        $catOm->setBreadcrumbs(['root']); // FIXME
        $catOm->setFrontImage('card-om.jpg');
        $catOm->setMetaDesc('Ciemność widzę! Ciemność!');
        $catOm->setMetaKeywords('');
        $catOm->setMetaTitle($catOm->getTitle());
        $catOm->setPageOrder(1); // FIXME
        $catOm->setTemplate('category');

        $catEp = new Category();
        $catEp->setName('eclipse-phase');
        $catEp->setTitle('Eclipse Phase');
        $catEp->setContent('<p>Transludzka przyszłość po upadku Ziemi</p>');
        $catEp->setParent($catRoot);
        $catEp->setBreadcrumbs(['root']); // FIXME
        $catEp->setFrontImage('card-eg.jpg');
        $catEp->setMetaDesc('Transludzka przyszłość po upadku Ziemi');
        $catEp->setMetaKeywords('');
        $catEp->setMetaTitle($catEp->getTitle());
        $catEp->setPageOrder(2); // FIXME
        $catEp->setTemplate('category');

        // load Tags

        // load Images

        // load Attachments

        // load Articles

        // load Comments

        // load Groups

        $groupAdmin = new Group();
        $groupAdmin->setName('CMS Admin');
        $groupAdmin->setStyle('warning');
        $groupAdmin->setRoles(['ROLE_ARTICLE_ALL', 'ROLE_ATTACHMENT_ALL', 'ROLE_CATEGORY_ALL', 'ROLE_COMMENT_ALL', 'ROLE_FILETYPE_ALL', 'ROLE_IMAGE_ALL', 'ROLE_LICENCE_ALL', 'ROLE_TAG_ALL']);
        $manager->persist($groupAdmin);

        $groupAuthor = new Group();
        $groupAuthor->setName('Author');
        $groupAuthor->setStyle('success');
        $groupAuthor->setRoles(['ROLE_ARTICLE_OWN', 'ROLE_ATTACHMENT_OWN', 'ROLE_CATEGORY_SEE', 'ROLE_COMMENT_OWN', 'ROLE_FILETYPE_SEE', 'ROLE_IMAGE_OWN', 'ROLE_LICENCE_SEE', 'ROLE_TAG_SEE']);
        $manager->persist($groupAuthor);

        $groupVisitor = $manager->getRepository(Group::class)->findOneBy(['name'=>'Visitor']);
        $groupVisitor->addRole('ROLE_ARTICLE_SEE')->addRole('ROLE_ATTACHMENT_SEE')->addRole('ROLE_CATEGORY_SEE')->addRole('ROLE_COMMENT_SEE')->addRole('ROLE_FILETYPE_SEE')->addRole('ROLE_IMAGE_SEE')->addRole('ROLE_LICENCE_SEE')->addRole('ROLE_TAG_SEE');
        $manager->persist($groupVisitor);

        // load Users

        $userSuperAdmin = $manager->getRepository(User::class)->findOneBy(['username'=>'root']);
        $userSuperAdmin->addGroup($groupAdmin);
        $manager->persist($userSuperAdmin);

        $userCmsAdmin = new User();
        $userCmsAdmin->setUsername('cmsadmin');
        $userCmsAdmin->setPassword('daikomio');
        $userCmsAdmin->addGroup($groupAdmin);
        $manager->persist($userCmsAdmin);

        $userAuthor = new User();
        $userAuthor->setUsername('author');
        $userAuthor->setPassword('daikomio');
        $userAuthor->addGroup($groupAuthor);
        $manager->persist($userAuthor);

        $manager->flush();
    }
}
