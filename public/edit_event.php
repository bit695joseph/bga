<?php
require_once __DIR__ . '../../app/config.php';
require_once SRC_DIR . 'App.php';
require_once SRC_VALIDATION_DIR . 'ValidationConstants.php';
require_once SRC_VALIDATION_DIR . 'EventFormValidator.php';
require_once SRC_MODELS_DIR . 'Event.php';


use \bga\app\data\Event;
use \bga\app\validation\EventFormValidator;
use \bga\app\App;
use \bga\app\validation\ValidationConstants as VC;
App::setPageTitle("Edit Event");
App::setActivePage("Events");
App::setBreadcrumbs("Edit Event", ["Events" => "events.php"]);
App::setClientPageData(['model' => 'Event','crud' => 'edit']);

$event = null;

if (!Event::findByRequestId($event))
{
    App::badRequest();
}

$venueVal = '';
$venueClass = '';
$venueMsg = '';

$scheduledVal = '';
$scheduledClass = '';
$scheduledMsg = '';


if (App::isPost()) {
    $v = new EventFormValidator();

    if ($v->validate($_POST)) {
        if ($event->updateAll($_POST))
            App::redirectTo('events.php');
        else App::serverError();
    } else {
        // Posted form values
        $invalidData = $v->getData();
        $venueVal = $invalidData['venue'];

        // Validation error messages
        $venueMsg = $v->getMessage('venue');
        $venueClass = $v->getBootstrapClass('venue');

    }
} else {
    $venueVal = $event->venue;
    $scheduledVal = $event->getScheduledForForm();
}

?>
<?php include VIEWS_DIR . 'top.php'; ?>


<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h1>Edit event</h1>
            <form id="event-form" action="edit_event.php" method="post" name="event_form">
                <input type="hidden" name="event_id" value="<?php echo $event->getId(); ?>">
                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="venue" class="col-form-label">Event venue</label>
                        <input id="venue" type="text" name="venue"
                               class="form-control <?php echo $venueClass; ?>"
                               minlength="<?php echo VC::EVENT_VENUE_MIN_LEN; ?>"
                               maxlength="<?php echo VC::EVENT_VENUE_MAX_LEN; ?>"
                               value="<?php App::e($venueVal); ?>"
                               autofocus
                               required>
                        <div class="invalid-feedback">
                            <?php echo $venueMsg; ?>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="scheduled" class="col-form-label">Date &amp; time</label>

                        <input id="scheduled" type="datetime-local" name="scheduled"
                               class="form-control <?php echo $scheduledClass; ?>"
                               value="<?php echo $scheduledVal; ?>"
                               required>
                        <div class="invalid-feedback">
                            <?php echo $scheduledMsg; ?>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
</div>

<?php include VIEWS_DIR . 'bottom.php'; ?>