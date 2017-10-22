<?php
require_once __DIR__ . '../../app/config.php';
require_once SRC_DIR . 'App.php';
require_once SRC_VALIDATION_DIR . 'ValidationConstants.php';
require_once SRC_VALIDATION_DIR . 'MemberFormValidator.php';
require_once SRC_MODELS_DIR . 'Member.php';


use \bga\app\data\Member;
use \bga\app\validation\MemberFormValidator;
use \bga\app\App;
use \bga\app\validation\ValidationConstants as VC;
App::setPageTitle("Edit Member");
App::setActivePage("Members");
App::setBreadcrumbs("Edit member", ["Members" => "members.php"]);
App::setClientPageData(['model' => 'Member','crud' => 'edit']);

$member = null;
$post = App::isPost();
if (!Member::findByRequestId($member))
{
    App::badRequest();
}

$firstName = '';
$lastName = '';
$phone = '';
$email = '';

$firstNameClass = '';
$lastNameClass = '';
$emailClass = '';
$phoneClass = '';

$firstNameMsg = '';
$lastNameMsg = '';
$emailMsg = '';
$phoneMsg = '';

if ($post) {
    $v = new MemberFormValidator();

    if ($v->validate($_POST)) {
        if ($member->updateAll($_POST)) App::redirectTo('members.php');
        else App::serverError();
    } else {
        // Posted form values
        $invalidData = $v->getData();
        $firstName = $invalidData['first_name'];
        $lastName = $invalidData['last_name'];
        $phone = $invalidData['phone'];
        $email = $invalidData['email'];

        // Validation error messages
        $firstNameMsg = $v->getMessage('first_name');
        $lastNameMsg = $v->getMessage('last_name');
        $emailMsg = $v->getMessage('email');
        $phoneMsg = $v->getMessage('phone');

        // Bootstrap validation classes for inputs
        $firstNameClass = $v->getBootstrapClass('first_name');
        $lastNameClass = $v->getBootstrapClass('last_name');
        $emailClass = $v->getBootstrapClass('email');
        $phoneClass = $v->getBootstrapClass('phone');
    }
} else {
    $firstName = $member->first_name;
    $lastName = $member->last_name;
    $phone = $member->phone;
    $email = $member->email;
}

?>
<?php include VIEWS_DIR . 'top.php'; ?>


<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h1>Editing <small class="text-muted"><?php App::e($member->fullName()); ?></small></h1>
            <form id="member-form" action="edit_member.php" method="post" name="member_form">
                <input type="hidden" name="member_id" value="<?php echo $member->getId(); ?>">
                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="first-name" class="col-form-label">First name</label>
                        <input id="first-name" type="text" name="first_name"
                               class="form-control <?php echo $firstNameClass; ?>"
                               minlength="<?php echo VC::NAME_MIN_LEN; ?>"
                               maxlength="<?php echo VC::NAME_MAX_LEN; ?>"
                               value="<?php App::e($firstName); ?>"
                               required>
                        <div class="invalid-feedback">
                            <?php echo $firstNameMsg; ?>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="last-name" class="col-form-label">Last name</label>
                        <input id="last-name" type="text" name="last_name"
                               class="form-control <?php echo $lastNameClass; ?>"
                               minlength="<?php echo VC::NAME_MIN_LEN; ?>"
                               maxlength="<?php echo VC::NAME_MAX_LEN; ?>"
                               value="<?php App::e($lastName); ?>"
                               required>
                        <div class="invalid-feedback">
                            <?php echo $lastNameMsg; ?>
                        </div>
                    </div>

                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email" class="col-form-label">Email</label>
                        <input id="email" type="email" name="email"
                               class="form-control <?php echo $emailClass; ?>"
                               title="Email address"
                               minlength="<?php echo VC::EMAIL_MIN_LEN; ?>"
                               maxlength="<?php echo VC::EMAIL_MAX_LEN; ?>"
                               value="<?php App::e($email); ?>"
                               required>
                        <div class="invalid-feedback">
                            <?php echo $emailMsg; ?>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone" class="col-form-label">Phone</label>
                        <input id="phone" type="text" name="phone"
                               class="form-control  <?php echo $phoneClass; ?>"
                               title="Phone number"
                               minlength="<?php echo VC::PHONE_MIN_LEN; ?>"
                               maxlength="<?php echo VC::PHONE_MAX_LEN; ?>"
                               value="<?php App::e($phone); ?>"
                               required>
                        <div class="invalid-feedback">
                            <?php echo $phoneMsg; ?>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
</div>

<?php include VIEWS_DIR . 'bottom.php'; ?>