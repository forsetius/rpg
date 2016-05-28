<?php
namespace Forseti\PagesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Forseti\AdminBundle\Entity\Group;
use Forseti\AdminBundle\Entity\User;
use Forseti\PagesBundle\Entity\Filetype;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // load Filetypes

        $filetypes = [
            'Archiwum ZIP'=>['file-archive-o', '#000', '', 'zip'],
            'Archiwum TAR.GZ'=>['file-archive-o', '#a00', '', 'tar.gz'],
            'Audio MP3'=>['file-audio-o', '#000', '', 'mp3'],
            'Audio OGG'=>['file-audio-o', '#a00', '', ['ogg', 'flac']],
            'Dokument HTML'=>['file-code-o', '#000', '', ['html', 'htm', 'mhtml']],
            'Dokument XML'=>['file-code-o', '#06a', '', ['xml', 'xsl']],
            'Dokument YAML'=>['file-code-o', '#a06', '', ['yml', 'yaml']],
            'Dokument JSON'=>['file-code-o', '#60a', '', ['json', 'geojson']],
            'Kod SQL'=>['file-text-o', '#a60', '', 'sql'],
            'Kod JS'=>['file-text-o', '#aa0', '', 'js'],
            'Kod CSS'=>['file-text-o', '#0aa', '', 'css'],
            'Kod PHP'=>['file-text-o', '#a0a', '', 'php', 'php4', 'php5', 'php7'],
            'Kod Pythona'=>['file-text-o', '#00a', '', 'py', 'pyc'],
            'Kod Ruby'=>['file-text-o', '#a00', '', 'rb'],
            'Skrypt powłoki'=>['file-text-o', '#0a0', '', 'sh'],
            'Dokument tekstowy'=>['file-text-o', '#000', '', 'txt'],
            'Dokument Worda'=>['file-code-o', '#000', '', ['doc, docx']],
            'Dokument OpenOffice/LibreOffice'=>['file-code-o', '#000', '', 'odf'],
            'Arkusz Excela'=>['file-code-o', '#0a0', '', ['xls', 'xlsx', 'xlsm', 'xlsa']],
            'Plik CSV'=>['file-excel-o', '#000', '', ['csv', 'tsv']],
            'Dokument PDF'=>['file-pdf-o', '#a00', '', 'pdf'],
            'Obraz JPG'=>['file-image-o', '#a0a', '', ['jpg', 'jpeg']],
            'Obraz GIF'=>['file-image-o', '#0aa', '', 'gif'],
            'Obraz BMP'=>['file-image-o', '#a00', '', 'bmp'],
            'Obraz PNG'=>['file-image-o', '#0a0', '', 'png'],
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

        // load Licances

        // load Categories

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

        $userSuperAdmin = new User();
        $userSuperAdmin->setUsername('root');
        $userSuperAdmin->setPassword('daikomio');
        $manager->persist($userSuperAdmin);

        $userCmsAdmin = new User();
        $userCmsAdmin->setUsername('admin');
        $userCmsAdmin->setPassword('daikomio');
        $manager->persist($userCmsAdmin);

        $userAuthor = new User();
        $userAuthor->setUsername('admin');
        $userAuthor->setPassword('daikomio');
        $manager->persist($userAuthor);

        $manager->flush();
    }
}
