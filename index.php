<?php

if (file_exists('setup.php'))
{
    header('Location: setup.php');
}

$folder = './';
require_once($folder . 'common.php');
$localization = new Localization($configLanguage);

for ($i = 1; $i <= 6; $i++)
{
    $fileName = $folder . 'data/advertisement' . $i . '.php';
    if (!file_exists($fileName))
    {
        file_put_contents($fileName, '<br/>');
    }
}

?>

<!doctype html>
<html ng-app="list">
<head>
    <title><?= $configListAddress . ' - ' . $configListTitle ?></title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/>
    <link rel="stylesheet" href="custom.css"/>
    <script src="//code.jquery.com/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/angular-sanitize/1.5.8/angular-sanitize.min.js"></script>
    <script src="//platform.twitter.com/widgets.js" type="text/javascript"></script>
    <script src="custom.js"></script>
</head>
<body>
<div class="container" ng-controller="SectionController">
    <div class="row"><br/></div>
    <div class="row">
        <div class="well well-top-bar text-center">
            <img class="pull-left" src="logo.png"/>
            <button class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#modalAddWebsite"><?= $localization->text('AddWebsite') ?></button>
            <div class="text-center"><?php include($folder . 'data/advertisement1.php'); ?></div>
        </div>
    </div>
    <div class="row text-center websites-row">
        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th colspan="3" class="no-border-top no-border-left"></th>
                <th colspan="3" class="no-border-top text-center"><?= $localization->text('today') ?></th>
                <th colspan="3" class="no-border-top text-center active"><?= $localization->text('yesterday') ?></th>
            </tr>
            <tr>
                <th class="col-rank text-center">#</th>
                <th class="col-change text-center">-</th>
                <th class="col-website text-left"><?= $localization->text('website') ?></th>
                <th class="col-online text-center"><?= $localization->text('online') ?></th>
                <th class="col-unique text-center"><?= $localization->text('unique') ?></th>
                <th class="col-total text-center"><?= $localization->text('total') ?></th>
                <th class="col-rank text-center active"><?= $localization->text('rank') ?></th>
                <th class="col-unique text-center active"><?= $localization->text('unique') ?></th>
                <th class="col-total text-center active"><?= $localization->text('total') ?></th>
            </tr>
            </thead>
            <tbody ng-class="{true:'display-table-row-group', false:'display-none'}[isLoaded]" style="display: none;">
            <?php for ($i = 0; $i < 5; $i++) { ?>
            <?php if ($i > 0) { ?>
            <tr ng-show="sections[<?= $i ?>].websites.length > 0">
                <td colspan="10"><?php include($folder . 'data/advertisement' . ($i + 1) . '.php'); ?></td>
            </tr>
            <?php } ?>
            <tr ng-repeat="website in sections[<?= $i ?>].websites">
                <td class="col-rank text-right">{{website.todayRank}}</td>
                <td class="col-change text-center">
                    <img src="images/new.png" ng-show="website.yesterdayRank == 0" />
                    <img src="images/same.png" ng-show="website.yesterdayRank > 0 && website.todayRank == website.yesterdayRank" />
                    <img src="images/up.png" ng-show="website.yesterdayRank > 0 && website.todayRank < website.yesterdayRank" />
                    <img src="images/down.png" ng-show="website.yesterdayRank > 0 && website.todayRank > website.yesterdayRank" />
                </td>
                <td class="col-website text-left">
                    <div class="div-website">
                        <a href="http://{{website.domain}}" target="_blank">
                            <b>{{website.domain}}</b> - {{website.title}}</a>
                    </div>
                </td>
                <td class="col-online text-center">{{website.online}}</td>
                <td class="col-unique text-right">{{website.todayUnique}}</td>
                <td class="col-total text-right">{{website.todayTotal}}</td>
                <td class="col-rank text-right active">{{website.yesterdayRank}}</td>
                <td class="col-unique text-right active">{{website.yesterdayUnique}}</td>
                <td class="col-total text-right active">{{website.yesterdayTotal}}</td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li ng-class="{true:'disabled', false:''}[pageInfo.getCurrentPage()==1]">
                    <a href="" ng-click="goToPage(1)">&laquo;</a>
                </li>
                <li ng-class="{true:'disabled', false:''}[pageInfo.getCurrentPage()==1]">
                    <a href="" ng-click="goToPage(pageInfo.getCurrentPage()-1)">&lsaquo;</a>
                </li>
                <li ng-class="{true:'active', false:''}[pageInfo.getCurrentPage()==page]" ng-repeat="page in pageInfo.getPages()">
                    <a href="" ng-click="goToPage(page)">{{page}}</a>
                </li>
                <li ng-class="{true:'disabled', false:''}[pageInfo.getCurrentPage()==pageInfo.getTotalPageCount()]">
                    <a href="" ng-click="goToPage(pageInfo.getCurrentPage()+1)">&rsaquo;</a>
                </li>
                <li ng-class="{true:'disabled', false:''}[pageInfo.getCurrentPage()==pageInfo.getTotalPageCount()]">
                    <a href="" ng-click="goToPage(pageInfo.getTotalPageCount())">&raquo;</a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="row">
        <div class="well text-center">
            <div class="statistics"><?= $localization->text('statistics') ?></div>
            <div>copyright &copy; 2016 <?= $configListAddress ?> | <?= $localization->text('allrightsreserved') ?> - <?= $localization->text('email') ?>: <?= $configListMail ?></div>
            <div class="share-box">
                <iframe src="http://www.facebook.com/plugins/like.php?href=http://<?= $configListAddress ?>/&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=verdana&amp;height=21"
                        scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:20px;" allowTransparency="true"></iframe>
                <a class="twitter-share-button" data-count="horizontal" data-text="<?= $configListTitle ?>" data-url="http://<?= $configListAddress ?>" href="https://twitter.com/share">Tweet</a>
            </div>
            <div>
                <?php include($folder . 'data/advertisement6.php'); ?>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalAddWebsite" tabindex="-1" role="dialog" aria-labelledby="modalAddWebsiteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="modalAddWebsiteLabel"><?= $localization->text('AddWebsite') ?></h4>
                </div>
                <div class="modal-body">
                    <?= $localization->text('AddWebsiteParagraph') ?>
                    <textarea readonly onfocus="this.select()" onclick="this.select()"
                              style="width:100%;height:80px;"><!-- <?= $configListAddress ?> - <?= $localization->text('countercode') ?> -->
<script type="text/javascript" src="http://<?= $configListAddress ?>/counter.php"></script>
<!-- <?= $configListAddress ?> - <?= $localization->text('countercode') ?> --></textarea>
                    <br/><br/>
                    <!-- <div class="alert alert-danger show"><?= $localization->text('AddWebsiteWarning') ?></div> -->
                </div>
            </div
        </div>
    </div>
</div>
</body>
</html>
