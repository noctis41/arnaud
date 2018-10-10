<?php  

$destinataire='gairaut.arnaud@laposte.net';  
?>

<?php  
$Previsualiser='<p class="bt">  
<input type="submit" name="previsualiser" tabindex="3" value="Prévisualiser"></p>';  
$Envoi="\n".'<p class="bt">  
<input name="envoi" tabindex="4" value="Envoyer" type="submit"></p>';  
if (isset($_POST['message']))  
  {  
    // La variable $verif va nous permettre d'analyser si la sémantique de l'email est bonne  
    $verif='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,5}$#';  
    //quelques remplacements pour les specialchars  
    $message=preg_replace('#(<|>)#', '-', $_POST['message']);  
    $message=str_replace('"', "'",$message);  
    $message=str_replace('&', 'et',$message);  
    $objet=preg_replace('#(<|>)#', '-', $_POST['objet']);  
    $objet=str_replace('"', "'",$objet);  
    $objet=str_replace('&', 'et',$objet);  
    // On assigne et/ou protège nos variables  
    $votremail=stripslashes(htmlentities($_POST['votremail']));  
    $message=stripslashes(htmlspecialchars($message));  
    $objet=stripslashes(htmlspecialchars($objet));  
    //input envoi/previsualiser  
    $envoi=htmlentities($_POST['envoi']);  
    $previsualiser=htmlentities($_POST['previsualiser']);  
    //on enlève les espaces  
    $votremail=trim($votremail);  
    $message=trim($message);  
    $objet=trim($objet);  

    $apercu_resultat='<p>Aperçu du résultat :</p>';  

    /*On vérifie si l'e mail et le message sont pleins, et on agit en fonction.  
      (on affiche Apercu du resultat, tel ou tel champ est vide, etc...*/  
    //Si ca ne vas pas (mal rempli, mail non valide...)  
    if((empty($message))or(empty($objet))or(!preg_match($verif,$votremail)))  
      {  
        //les 3 champs sont vides  
        if(empty($votremail)and(empty($message))and(empty($objet)))  
          {  
            echo '<p>Tous les champs sont vides.</p>';  
            $message='';$gairaut.arnaud@laposte.net='';$objet='';$apercu_resultat='';  
          }  
        //un des champs est vide  
        else  
          {  
            if(!preg_match($gairaut.arnaud@laposte.net))  
              echo'<p>Votre adresse e-mail n\'est pas valide.</p>';  
            else  
            {  
              echo'<p>Il faut remplir tous les champs !</p>';  
              if(empty($message))  
                $apercu_resultat='';  
            }  
          }  
      }  
    //Si les deux sont pleins et que l'adresse est valide, on envoie on on prévisualise sans envoi  
    else  
      {  
        $domaine=preg_replace('#[^@]+@(.+)#','$1',$votremail);  
        $DomaineMailExiste=checkdnsrr($domaine,'MX');  
        if(!$DomaineMailExiste)  
          echo'<p>Le nom de domaine de l\'adresse e-mail que vous avez donné n\'existe pas.</p>';  
        elseif(!empty($previsualiser))  
            {  
              $apercu_resultat='<p>Votre message et votre adresse e-mail sont valides et prêts à être envoyés.  
              <br>Vous n\'avez plus qu\'à cliquer sur le bouton "Envoyer".<br>Prévisualisation :</p>';  
              $Previsualiser='';  
            }  
        elseif(!empty($envoi))  
            {  
              $objet='[SITE] : '.$objet;  
              $headers='From:'.$votremail."\r\n".'To:'.$mail."\r\n".'Subject:'.$objet."\r\n".'Content-type:text/plain;charset=iso-8859-1'."\r\n".'Sent:'.date('l, F d, Y H:i');  
              if(mail($destinataire,$objet,$message,$headers))  
              {  
                echo '<p>Votre message a bien été envoyé. Merci.</p><p><a href="/">Retour à la page d\'accueil</a></p>';  
                $Envoi='';  
                $Previsualiser='';  
              }  
              else  
                echo'<p>Un problème est survenu durant l\'envoi du mail.</p>';  
            }  
        else  
          echo'<p>Une condition innatendue est survenue lors de l\'exécution du script.</p>';  
      }  
echo $apercu_resultat;  
  }  
else  
  {  
  echo '<p>Vous pouvez utiliser ce formulaire pour me contacter.</p>';  
  $votremail='';$message='';  
  }  
$bas_formulaire=$Previsualiser.$Envoi;  
?>  
