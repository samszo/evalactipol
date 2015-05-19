# Plan #

  * Introduction
  * I.  Modèle Logique de Données Relationnel (MLDR)
  * II. Diagramme d'activités
  * III.Représentation avec FireShot
> > • III.1. Page des départements<br>
<blockquote>• III.2. Page des députés d'un département<br>
• III.3. Page d'un député<br>
• III.4. Page des questions d'un député<br>
</blockquote><ul><li>IV. Bibliothèques PHP</li></ul>


<h1>Introduction</h1>

Cette page permet de présenter les schémas conceptuels pour le développement de l'outil. D'abord le modèle logique de données relationnelles (MLDR) utile pour créer la base de données qui gère notre application. Ensuite le diagramme d'activités qui illustre les différentes actions effectuées et le passage entre les différentes étapes. Enfin une représentation graphique faite avec <a href='https://addons.mozilla.org/fr/firefox/addon/5648'>FireShot</a> des différentes pages parsées et des informations collectées durant ce processus.<br>
<br>
<br>
<br>
<h1>Modèle Logique de Données Relationnel (MLDR)</h1>
<blockquote><img src='http://evalactipol.googlecode.com/svn/trunk/documentation/MLDR_BD/MLD_officiel.png' /></blockquote>

<h1>II. Diagramme d'activités</h1>
<blockquote><img src='http://evalactipol.googlecode.com/svn/trunk/documentation/Diagramme_activites/Diagramme_activites.png' /></blockquote>

<h1>III. Représentation avec <a href='https://addons.mozilla.org/fr/firefox/addon/5648'>FireShot</a></h1>

<h2>III.1 Page des départements</h2>

<a href='http://www.laquadrature.net/wiki/Deputes_par_departement'>Lien de la page dans le site de l'Assemblée Nationale</a>

<img src='http://evalactipol.googlecode.com/svn/trunk/documentation/Representation_Fireshot/Page1.png' />

<h2>III.2 Page des députés d'un département</h2>

<a href='http://www.laquadrature.net/wiki/Deputes_01'>Lien de la page dans le site de l'Assemblée Nationale</a>


<img src='http://evalactipol.googlecode.com/svn/trunk/documentation/Representation_Fireshot/Page2.png' />

<h2>III.3 Page d'un député</h2>

<a href='http://www.laquadrature.net/wiki/XavierBreton'>Lien de la page dans le site de l'Assemblée Nationale</a>

<img src='http://evalactipol.googlecode.com/svn/trunk/documentation/Representation_Fireshot/Page3.png' />

<h2>III.4 Page des questions d'un député</h2>

<a href='http://recherche2.assemblee-nationale.fr/resultats_tribun.jsp?id_auteur=Breton%20Xavier&nom_auteur=Xavier%20Breton&legislature=13&typedoc=Questions'>Lien de la page dans le site de l'Assemblée Nationale</a>

<img src='http://evalactipol.googlecode.com/svn/trunk/documentation/Representation_Fireshot/Page4.png' />

<h1>IV. Bibliothèques PHP</h1>

<ul><li>La bibliothèque <a href='http://www.manuelphp.com/php/ref.curl.php#ref.curl'>libcurl</a> de PHP<br>
</li><li>La bibliothèque <a href='http://sourceforge.net/search/?type_of_search=soft&words=simple_html_dom'>simple_htmp_dom</a>