<?php

namespace App\Service;

class UserFunctions
{

    public function createAvatarFile($username) {
        $file = 'img/users/saves/default.png';
        $newfile = 'img/users/'.$username.'.png';
        if (!copy($file, $newfile)) {
            echo "<p class='failed'>Failed to create new user avatar\n</p>";
        }
        else {
            return $newfile;
        }
    }

    public function changeAvatar($file,$user) {
        $filename = $user->getUsername().'.png';
        $upload = move_uploaded_file($file, "./img/users/$filename");
       
    }
    public function uploaddoc($file,$user,$nomdoc) {
        $filename = $user->getId().$nomdoc.'.pdf';
        $upload = move_uploaded_file($file, "./doc/$filename");
       
    }
    public function uploaddoc2($nomdoc,$user,$doc) {
        $filename = $user->getId().$nomdoc.'.pdf';
        $upload = move_uploaded_file($doc, "./doc2/$filename");
       
    }

    public function roleStr(string $role) {
        switch ($role) {
            case 'ROLE_ETUD':
                return 'Etudiant';
                break;
            
            case 'ROLE_ENSE':
                return 'Enseignant';
                break;

            case 'ROLE_ADMIN':
                return 'Administrateur';
                break;
        }
    }

}
?>