<?php

global $global;
require_once $global['systemRootPath'] . 'plugin/Plugin.abstract.php';

class CustomizeUser extends PluginAbstract {

    public function getDescription() {
        $txt = "Fine Tuning User Profile";
        return $txt;
    }

    public function getName() {
        return "CustomizeUser";
    }

    public function getUUID() {
        return "55a4fa56-8a30-48d4-a0fb-8aa6b3fuser3";
    }

    public function getPluginVersion() {
        return "1.0";
    }

    public function getEmptyDataObject() {
        global $advancedCustom;
        $obj = new stdClass();
        $obj->userCanAllowFilesDownload = false;
        $obj->userCanAllowFilesShare = false;
        $obj->userCanAllowFilesDownloadSelectPerVideo = false;
        $obj->userCanAllowFilesShareSelectPerVideo = false;
        $obj->userCanProtectVideosWithPassword = true;

        $obj->usersCanCreateNewCategories = !isset($advancedCustom->usersCanCreateNewCategories) ? false : $advancedCustom->usersCanCreateNewCategories;
        $obj->userCanNotChangeCategory = !isset($advancedCustom->userCanNotChangeCategory) ? false : $advancedCustom->userCanNotChangeCategory;
        $obj->userCanNotChangeUserGroup = false;
        $obj->userMustBeLoggedIn = !isset($advancedCustom->userMustBeLoggedIn) ? false : $advancedCustom->userMustBeLoggedIn;
        $obj->onlyVerifiedEmailCanUpload = !isset($advancedCustom->onlyVerifiedEmailCanUpload) ? false : $advancedCustom->onlyVerifiedEmailCanUpload;
        $obj->sendVerificationMailAutomaic = !isset($advancedCustom->sendVerificationMailAutomaic) ? false : $advancedCustom->sendVerificationMailAutomaic;
        
        $o = new stdClass();
        $o->type = "textarea";
        $o->value = "Just a quick note to say a big welcome and an even bigger thank you for registering";
        
        $obj->verificationMailTextLine1 = "Just a quick note to say a big welcome and an even bigger thank you for registering";
        $obj->verificationMailTextLine2 = "Cheers, %s Team.";
        $obj->verificationMailTextLine3 = "You are just one click away from starting your journey with %s!";
        $obj->verificationMailTextLine4 = "All you need to do is to verify your e-mail by clicking the link below";
        
        $obj->unverifiedEmailsCanNOTLogin = !isset($advancedCustom->unverifiedEmailsCanNOTLogin) ? false : $advancedCustom->unverifiedEmailsCanNOTLogin;
        $obj->unverifiedEmailsCanNOTComment = false;
        $obj->newUsersCanStream = !isset($advancedCustom->newUsersCanStream) ? false : $advancedCustom->newUsersCanStream;
        $obj->doNotIndentifyByEmail = !isset($advancedCustom->doNotIndentifyByEmail) ? false : $advancedCustom->doNotIndentifyByEmail;
        $obj->doNotIndentifyByName = !isset($advancedCustom->doNotIndentifyByName) ? false : $advancedCustom->doNotIndentifyByName;
        $obj->doNotIndentifyByUserName = !isset($advancedCustom->doNotIndentifyByUserName) ? false : $advancedCustom->doNotIndentifyByUserName;
        $obj->hideRemoveChannelFromModeYoutube = !isset($advancedCustom->hideRemoveChannelFromModeYoutube) ? false : $advancedCustom->hideRemoveChannelFromModeYoutube;
        $obj->showChannelBannerOnModeYoutube = !isset($advancedCustom->showChannelBannerOnModeYoutube) ? false : $advancedCustom->showChannelBannerOnModeYoutube;
        $obj->encryptPasswordsWithSalt = !isset($advancedCustom->encryptPasswordsWithSalt) ? false : $advancedCustom->encryptPasswordsWithSalt;
        $obj->requestCaptchaAfterLoginsAttempts = !isset($advancedCustom->requestCaptchaAfterLoginsAttempts) ? 0 : $advancedCustom->requestCaptchaAfterLoginsAttempts;
        $obj->disableSignOutButton = false;
        $obj->disableNativeSignUp = !isset($advancedCustom->disableNativeSignUp) ? false : $advancedCustom->disableNativeSignUp;
        $obj->disableNativeSignIn = !isset($advancedCustom->disableNativeSignIn) ? false : $advancedCustom->disableNativeSignIn;
        $obj->disablePersonalInfo = !isset($advancedCustom->disablePersonalInfo) ? true : $advancedCustom->disablePersonalInfo;
        $obj->userCanChangeUsername = true;

        $obj->signInOnRight = false;
        $obj->doNotShowRightProfile = false;
        $obj->doNotShowLeftProfile = false;

        $obj->forceLoginToBeTheEmail = false;
        $obj->emailMustBeUnique = false;

        // added on 2019-02-11
        $o = new stdClass();
        $o->type = "textarea";
        $o->value = "";
        $obj->messageToAppearBelowLoginBox = $o;

        $obj->keepViewerOnChannel = false;
        $obj->showLeaveChannelButton = false;
        $obj->addChannelNameOnLinks = true;

        $obj->doNotShowTopBannerOnChannel = false;

        $obj->doNotShowMyChannelNameOnBasicInfo = false;
        $obj->doNotShowMyAnalyticsCodeOnBasicInfo = false;
        $obj->doNotShowMyAboutOnBasicInfo = false;

        $obj->MyChannelLabel = "My Channel";
        $obj->afterLoginGoToMyChannel = false;
        $obj->afterLoginGoToURL = "";
        $obj->afterLogoffGoToMyChannel = false;
        $obj->afterLogoffGoToURL = "";
        $obj->allowDonationLink = false;
        $obj->donationButtonLabel = __('Donation');

        $obj->showEmailVerifiedMark = true;

        $obj->Checkmark1Enabled = true;
        $obj->Checkmark1HTML = '<i class="fas fa-check" data-toggle="tooltip" data-placement="bottom" title="Trustable User"></i>';
        $obj->Checkmark2Enabled = true;
        $obj->Checkmark2HTML = '<i class="fas fa-shield-alt" data-toggle="tooltip" data-placement="bottom" title="Official User"></i>';
        $obj->Checkmark3Enabled = true;
        $obj->Checkmark3HTML = '<i class="fas fa-certificate fa-spin" data-toggle="tooltip" data-placement="bottom" title="Premium User"></i>';


        return $obj;
    }

    public function getUserOptions() {
        $obj = $this->getDataObject();
        if ($obj->Checkmark1Enabled) {
            $userOptions["Checkmark 1"] = "checkmark1";
        }
        if ($obj->Checkmark2Enabled) {
            $userOptions["Checkmark 2"] = "checkmark2";
        }
        if ($obj->Checkmark3Enabled) {
            $userOptions["Checkmark 3"] = "checkmark3";
        }
        return $userOptions;
    }

    static function canDownloadVideosFromUser($users_id) {
        global $config;
        $obj = AVideoPlugin::getObjectDataIfEnabled("CustomizeUser");
        if (empty($obj) || empty($obj->userCanAllowFilesDownload)) {
            return $config->getAllow_download();
        }
        $user = new User($users_id);
        return !empty($user->getExternalOption('userCanAllowFilesDownload'));
    }

    static function setCanDownloadVideosFromUser($users_id, $value = true) {
        $obj = AVideoPlugin::getObjectDataIfEnabled("CustomizeUser");
        if (empty($obj) || empty($obj->userCanAllowFilesDownload)) {
            return false;
        }
        $user = new User($users_id);
        return $user->addExternalOptions('userCanAllowFilesDownload', $value);
    }

    static function canShareVideosFromUser($users_id) {
        global $advancedCustom;

        if (!empty($advancedCustom->disableShareAndPlaylist)) {
            return false;
        }

        $obj = AVideoPlugin::getObjectDataIfEnabled("CustomizeUser");
        if (empty($obj) || empty($obj->userCanAllowFilesShare)) {
            return true;
        }
        $user = new User($users_id);
        return !empty($user->getExternalOption('userCanAllowFilesShare'));
    }

    static function setCanShareVideosFromUser($users_id, $value = true) {
        $obj = AVideoPlugin::getObjectDataIfEnabled("CustomizeUser");
        if (empty($obj) || empty($obj->userCanAllowFilesShare)) {
            return false;
        }
        $user = new User($users_id);
        return $user->addExternalOptions('userCanAllowFilesShare', $value);
    }

    static function getSwitchUserCanAllowFilesDownload($users_id) {
        global $global;
        include $global['systemRootPath'] . 'plugin/CustomizeUser/switchUserCanAllowFilesDownload.php';
    }

    static function getSwitchUserCanAllowFilesShare($users_id) {
        global $global;
        include $global['systemRootPath'] . 'plugin/CustomizeUser/switchUserCanAllowFilesShare.php';
    }

    public function getMyAccount($users_id) {

        $objcu = AVideoPlugin::getObjectDataIfEnabled("CustomizeUser");

        if (!empty($objcu) && !empty($objcu->userCanAllowFilesDownload)) {
            echo '<div class="form-group">
    <label class="col-md-4 control-label">' . __("Allow Download My Videos") . '</label>
    <div class="col-md-8 inputGroupContainer">';
            self::getSwitchUserCanAllowFilesDownload($users_id);
            echo '</div></div>';
        }
        if (!empty($objcu) && !empty($objcu->userCanAllowFilesShare)) {
            echo '<div class="form-group">
    <label class="col-md-4 control-label">' . __("Allow Share My Videos") . '</label>
    <div class="col-md-8 inputGroupContainer">';
            self::getSwitchUserCanAllowFilesShare($users_id);
            echo '</div></div>';
        }
    }

    public function getTags() {
        return array('free', 'customization', 'users');
    }

    public function getChannelButton() {
        global $global, $isMyChannel;
        if (!$isMyChannel) {
            return "";
        }
        $objcu = AVideoPlugin::getObjectDataIfEnabled("CustomizeUser");
        echo "<div style=\"float:right\">";
        if (!empty($objcu) && !empty($objcu->userCanAllowFilesDownload)) {
            echo '<div style=" margin:0 20px 10px 0;  height: 15px;">';
            echo '<div class="" style="max-width: 100px; float:right;"> ';
            self::getSwitchUserCanAllowFilesDownload(User::getId());
            echo '</div>
    <label class="control-label" style="float:right; margin:0 10px;">' . __("Allow Download My Videos") . '</label></div>';
        }
        if (!empty($objcu) && !empty($objcu->userCanAllowFilesShare)) {
            echo '<div style=" margin:0 20px 10px 0; height: 15px;">';
            echo '<div class="" style="max-width: 100px; float:right;"> ';
            self::getSwitchUserCanAllowFilesShare(User::getId());
            echo '</div>
    <label class="control-label" style="float:right; margin:0 10px;">' . __("Allow Share My Videos") . '</label></div>';
        }
        echo "</div>";
    }

    public function getVideoManagerButton() {
        global $isMyChannel;
        $isMyChannel = true;
        return self::getChannelButton();
    }

    static function canDownloadVideosFromVideo($videos_id) {
        $video = new Video("", "", $videos_id);
        if (empty($video)) {
            return false;
        }
        $users_id = $video->getUsers_id();
        if (!self::canDownloadVideosFromUser($users_id)) {
            return false;
        }
        $category = new Category($video->getCategories_id());
        if (is_object($category) && !$category->getAllow_download()) {
            return false;
        }
        $obj = AVideoPlugin::getObjectDataIfEnabled("CustomizeUser");
        if (!empty($obj->userCanAllowFilesDownloadSelectPerVideo)) {
            if (empty($video->getCan_download())) {
                return false;
            }
        }
        return true;
    }

    static function canShareVideosFromVideo($videos_id) {
        $video = new Video("", "", $videos_id);
        if (empty($video)) {
            return false;
        }
        $users_id = $video->getUsers_id();
        if (!self::canShareVideosFromUser($users_id)) {
            return false;
        }
        $obj = AVideoPlugin::getObjectDataIfEnabled("CustomizeUser");
        if (!empty($obj->userCanAllowFilesShareSelectPerVideo)) {
            if (empty($video->getCan_share())) {
                return false;
            }
        }
        return true;
    }

    public function onUserSignup($users_id) {
        global $global;
        $obj = $this->getDataObject();

        if ($obj->sendVerificationMailAutomaic) {
            url_get_contents("{$global['webSiteRootURL']}objects/userVerifyEmail.php?users_id=$users_id");
        }
    }

    public function getWatchActionButton($videos_id) {
        global $global, $video;
        $obj = $this->getDataObject();
        include $global['systemRootPath'] . 'plugin/CustomizeUser/actionButton.php';
    }

    public function getHTMLMenuRight() {
        global $global;
        $obj = $this->getDataObject();
        if ($obj->keepViewerOnChannel) {
            include $global['systemRootPath'] . 'plugin/CustomizeUser/channelMenuRight.php';
        }
    }

    public function getModeYouTube($videos_id) {
        global $global, $config;
        $cansee = User::canWatchVideoWithAds($videos_id);
        $obj = $this->getDataObject();
        if (!$cansee) {
            if (!AVideoPlugin::isEnabled('Gallery') && !AVideoPlugin::isEnabled('YouPHPFlix2') && !AVideoPlugin::isEnabled('YouTube')) {
                header("Location: {$global['webSiteRootURL']}user?msg=" . urlencode(__("Sorry, this video is private")));
            } else {
                header("Location: {$global['webSiteRootURL']}?msg=" . urlencode(__("Sorry, this video is private")));
            }
            exit;
        } else if($obj->userCanProtectVideosWithPassword){
            if (!$this->videoPasswordIsGood($videos_id)) {
                $video = Video::getVideoLight($videos_id);
                include "{$global['systemRootPath']}plugin/CustomizeUser/confirmVideoPassword.php";
                exit;
            }
        }
    }

    public static function videoPasswordIsGood($videos_id) {
        $video = new Video("", "", $videos_id);
        $videoPassword = $video->getVideo_password();
        if (empty($videoPassword)) {
            return true;
        }
        if (empty($_SESSION['video_password'][$videos_id]) || $videoPassword !== $_SESSION['video_password'][$videos_id]) {
            if (!empty($_POST['video_password']) && $_POST['video_password'] == $videoPassword) {
                _session_start();
                $_SESSION['video_password'][$videos_id] = $_POST['video_password'];
                return true;
            }
            return false;
        }
        return true;
    }

    public function getEmbed($videos_id) {
        $this->getModeYouTube($videos_id);
    }

    public function getStart() {
        global $global;
        $obj = $this->getDataObject();
        $thisScriptFile = pathinfo($_SERVER["SCRIPT_FILENAME"]);
        if (!empty($obj->userMustBeLoggedIn) &&
                ($thisScriptFile["basename"] === 'index.php' ||
                $thisScriptFile["basename"] === "channel.php" ||
                $thisScriptFile["basename"] === "channels.php" ||
                $thisScriptFile["basename"] === "trending.php") &&
                !User::isLogged()) {
            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            header("Location: {$global['webSiteRootURL']}user?redirectUri=" . urlencode($actual_link));
            exit;
        }
    }

}
