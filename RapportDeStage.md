# Plan #

  * Introduction
  * I.  Manuel d’utilisation de Evalactipol
> > • I.1. Page des départements<br>
<blockquote>• I.1.1. Les informations générales concernant un département<br>
• I.1.2. La liste des députés d’un département<br>
• I.1.3. Les statistiques des députés d’un département<br>
</blockquote><blockquote>• I.2. Page d’informations sur les députés<br></blockquote></li></ul>

<h1>I. Manuel d’utilisation de Evalactipol</h1>

<h2>I.1 Page des départements</h2>

Cette page présente à l’utilisateur une interface de navigation entre les différents départements de France. Ces départements sont représentés sous la forme d’une arborescence facile à exploiter en un simple clic.<br>
<br>
<img src='http://evalactipol.googlecode.com/svn/trunk/documentation/fireshot_rappot_stage/page_des_départements.png' />

La sélection d’un département permet d’afficher l’ensemble des informations qui le concerne. Pour notre application, on s’intéresse à trois types d’informations :<br>
<ul><li>Les informations générales d’un département.<br>
</li><li>La liste des députés d’un département.<br>
</li><li>Les statistiques qui concernent l’activité politique des députés d’un département.</li></ul>


<h3>I.1.1 Les informations générales concernant un département</h3>

La sélection d’un département dans la première page permet d’afficher les informations générales du département sélectionné. Ces informations prennent la forme d’une listbox de deux colonnes : la première présente le nom de l’information extraite. Quant à la deuxième, elle présente sa valeur.<br>
<br>
<img src='http://evalactipol.googlecode.com/svn/trunk/documentation/fireshot_rappot_stage/infos_generales_departement.png' />

<h3>I.1.2 La liste des députés d’un département</h3>

La sélection d’un département permet d’extraire la liste des députés de ce dernier. Pour permettre une meilleure navigation, les députés du département sélectionné sont représentés par une arborescence. Celle-ci permettra à l’utilisateur de sélectionner un député pour extraire les informations relatives à ce député.<br>
<br>
<img src='http://evalactipol.googlecode.com/svn/trunk/documentation/fireshot_rappot_stage/tree_deputes_depart.png' />

<h3>I.1.3 Les statistiques des députés d’un département</h3>

L’application permet à l’intéressé d’obtenir une vision précise de l’évolution de l’activité politique de tous les députés au sein de l’Assemblée Nationale. En sélectionnant un département, un graphe  s’affiche en bas de la page permettant d’illustrer l’activité politique d’un député au cours du temps.<br>
<br>
<img src='http://evalactipol.googlecode.com/svn/trunk/documentation/fireshot_rappot_stage/graphe1.png' />

<ul><li>Présentation du graphe<br>
Les deux schémas ci-dessous permettent de représenter les différentes fonctionnalités offertes par le graphe d’évaluation de l’activité des députés.</li></ul>

<img src='http://evalactipol.googlecode.com/svn/trunk/documentation/fireshot_rappot_stage/presentation_graphe.png' />

<img src='http://evalactipol.googlecode.com/svn/trunk/documentation/fireshot_rappot_stage/graphe2.png' />

<ul><li>Définition des plages temporelles</li></ul>

Pour permettre une meilleure visibilité de l’évolution de l’activité politique des députés au cours du temps, notre choix était de définir cinq plages temporelles du 01 Juillet 2007 au 01 Janvier 2010. Chaque plage temporelle s’étend sur six mois. Ces plages sont réparties comme suit :<br>
<blockquote>• Première plage : du 01 Juillet 2007 au 01 Janvier 2008.<br>
• Deuxième plage : du 02 Janvier 2008 au 01 Juillet 2008.<br>
• Troisième plage : du 02 Juillet 2008 au 01 Janvier 2009.<br>
• Quatrième plage : du 02 Janvier 2009 au 01 Juillet 2009.<br>
• Cinquième plage : du 02 Juillet 2009 au 01 Janvier 2010.<br></blockquote>

Remarque : Il est à noter que le calcul des nombres de critères d’évaluation (nombre de questions, nombre de mots-clefs, nombre de rubriques) s’effectue plage temporelle par plage temporelle. Le nombre de critères d’évaluation n’est pas cumulé d’une plage à une autre : pour chaque critère, on ne calcule que le nombre qui produit dans la période définie par chaque plage.<br>
<br>
<ul><li>Avantages du graphe</li></ul>

L’objectif de notre application est d’évaluer l’activité des députés, notamment leurs interventions au sein de l’Assemblée Nationale. L’avantage majeur du graphe est qu’il présente à l’utilisateur une grande palette de critères d’évaluation. C’est un graphe riche en terme d’informations. Il permet donc de répondre à plusieurs questions. La réponse à ces questions se trouve dans un seul graphe, centralisant plusieurs informations et présentant une grande souplesse par le passage entre les différents critères d’évaluation. Cette centralisation des informations est très bénéfique à l’utilisateur, qui par un simple clic, peut avoir la réponse à la majorité des questions qu’il pourrait se poser et peut avoir une vision de plus en plus précise de l’activité des députés au cours du temps.<br>
Dans ce qui suit, on va présenter l’ensemble des questions qui pourraient être posées par un utilisateur et on va démontrer comment le graphe permet de répondre à ces questions d’une manière précise, souple et approfondie.<br>
<br>
<blockquote>• Quel est le nombre de questions posées par un député à une date donnée et comment cela évolue-t-il dans le temps?</blockquote>

<img src='http://evalactipol.googlecode.com/svn/trunk/documentation/fireshot_rappot_stage/nb_questions.png' />

<blockquote>• Quel est le nombre de mots-clefs d’un député par rapport au nombre de questions à une date donnée et comment cela évolue-t-il dans le temps?</blockquote>

<img src='http://evalactipol.googlecode.com/svn/trunk/documentation/fireshot_rappot_stage/mc_questions.png' />

<blockquote>• Quel est le nombre de rubriques d’un député par rapport au nombre de questions à une date donnée et comment cela évolue-t-il dans le temps?</blockquote>

<img src='http://evalactipol.googlecode.com/svn/trunk/documentation/fireshot_rappot_stage/rub_question.png' />

<blockquote>• Quel est le nombre de rubriques d’un député par rapport au nombre de mots-clefs à une date donnée et comment cela évolue-t-il dans le temps?</blockquote>

<img src='http://evalactipol.googlecode.com/svn/trunk/documentation/fireshot_rappot_stage/rub_mc.png' />

<blockquote>• Quel député a posé le plus de questions dans un département donné à une date donnée et comment cela évolue-t-il dans le temps?</blockquote>

<img src='http://evalactipol.googlecode.com/svn/trunk/documentation/fireshot_rappot_stage/plus_Questions.png' />

<blockquote>• Quel député regroupe le plus de mots-clefs dans un département donné à une date donnée et comment cela évolue-t-il dans le temps?</blockquote>

<img src='http://evalactipol.googlecode.com/svn/trunk/documentation/fireshot_rappot_stage/plus_MC.png' />

<blockquote>• Quel député regroupe le plus de rubriques dans un département donné à une date donnée et comment cela évolue-t-il dans le temps?</blockquote>

<img src='http://evalactipol.googlecode.com/svn/trunk/documentation/fireshot_rappot_stage/plus_Rub.png' />

<blockquote>• Comment évolue le nombre de questions posées par un député au cours du temps ?</blockquote>

<img src='http://evalactipol.googlecode.com/svn/trunk/documentation/fireshot_rappot_stage/evolution_quest.png' />

<blockquote>• Comment évolue le nombre de mots-clefs d’un député au cours du temps ?</blockquote>

<img src='http://evalactipol.googlecode.com/svn/trunk/documentation/fireshot_rappot_stage/evolution_mc.png' />

<blockquote>• Comment évolue le nombre de rubriques d’un député au cours du temps ?</blockquote>

<img src='http://evalactipol.googlecode.com/svn/trunk/documentation/fireshot_rappot_stage/evolution_rub.png' />

<blockquote>• Quel est le nombre total des questions de tous les députés d’un département ?</blockquote>

<img src='http://evalactipol.googlecode.com/svn/trunk/documentation/fireshot_rappot_stage/nb_tous_quest.png' />


Ainsi, il paraît clair que la richesse des informations et des critères d’évaluation que renferme ce graphe permet à l’utilisateur de trouver dans un graphe unique l’ensemble des réponses à ses questions. Il suffit de changer les critères d’évaluation dans les listes déroulantes du graphe en choisissant le critère voulu. En outre, le graphe permet d’avoir une dimension temporelle de l’évolution de l’activité politique des députés. Pour cela, il suffit de déplacer manuellement le curseur du temps. Une manière automatique est également disponible en appuyant simplement sur la touche ‘Play’ en bas du graphe. Ce graphe permet, de plus, de se focaliser sur l’activité politique d’un seul député. Il suffit de sélectionner le nom et le prénom de l’utilisateur dans la partie traitant des députés.<br>
<br>
<ul><li>Inconvénients du graphe</li></ul>

L’inconvénient majeur du graphe est que son temps de réponse dépend essentiellement des plages temporelles définies. En effet, à partir de plus de cinq plages temporelles, le temps de réponse se dégrade de façon visible. Cela nous amène à définir cinq plages temporelles sur deux ans, chacune s’étendant sur six mois.<br>
<br>
<br>
<h2>I.2 Page d’informations sur les députés</h2>

La première page se propose, tout d’abord, de fournir les informations qui concernent les départements français, notamment les informations générales ainsi que les noms et les statistiques des députés par département. Ensuite, il est intéressant de se pencher sur les informations qui concernent chaque député.<br>
Cette page renferme les informations suivantes, par un simple clic sur un député dans le tree des députés d’un département:<br>
<br>
<ul><li>Les cantons sous sa responsabilité.<br>
</li><li>Ses informations générales.<br>
</li><li>Ses questions.<br>
</li><li>Ses mots-clefs.<br>
</li><li>Ses rubriques.</li></ul>

<img src='http://evalactipol.googlecode.com/svn/trunk/documentation/fireshot_rappot_stage/page_infos_dun_député.png' />