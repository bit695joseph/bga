<?php
require_once __DIR__ . '../../app/config.php';
require_once SRC_DIR . 'App.php';
require_once SRC_VALIDATION_DIR . 'ValidationConstants.php';
require_once SRC_VALIDATION_DIR . 'EventFormValidator.php';
require_once SRC_MODELS_DIR . 'Event.php';

use \bga\app\data\EVent;
use \bga\app\validation\EventFormValidator;
use \bga\app\App;
use \bga\app\validation\ValidationConstants as VC;

App::setPageTitle("Create Event");
App::setActivePage("Events");
App::setBreadcrumbs("Create event", ["Events" => "events.php"]);
App::setClientPageData(['model' => 'Event','crud' => 'create']);

$event_venue = '';
$venueClass = '';
$venueMsg = '';

$event_scheduled = null;
$scheduledClass = '';
$scheduledMsg = '';

if (App::isPost()) {
    $v = new EventFormValidator();

    if ($v->validate($_POST)) {

        $event = new Event($_POST);

        if ($event->insert()) {

            header('Location: events.php');
            exit();

        } else {
            header('Location: error500.php');
            exit();
        }

    } else {

        // Posted form values
        $invalidData = $v->getData();
        $event_venue = $invalidData['venue'];
        $event_scheduled = $invalidData['scheduled'];

        $venueMsg = $v->getMessage('venue');
        $venueClass = $v->getBootstrapClass('venue');

        $scheduledMsg = $v->getMessage('scheduled');
        $scheduledClass = $v->getBootstrapClass('scheduled');
    }
}

?>
<?php include VIEWS_DIR . 'top.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h1>Create event</h1>
            <form id="event-form" action="create_event.php" method="post" name="event_form">

                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="name" class="col-form-label">Event venue</label>
                        <input id="venue" type="text" name="venue"
                               class="form-control <?php echo $venueClass; ?>"
                               minlength="<?php echo VC::EVENT_VENUE_MIN_LEN; ?>"
                               maxlength="<?php echo VC::EVENT_VENUE_MAX_LEN; ?>"
                               value="<?php App::e($event_venue); ?>"
                               placeholder="123 Place Street etc"
                               autofocus required>
                        <div class="invalid-feedback">
                            <?php echo $venueMsg; ?>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="scheduled" class="col-form-label">Date &amp; time</label>

                        <input id="scheduled" type="datetime-local" name="scheduled"
                               class="form-control <?php echo $scheduledClass; ?>"
                               value="<?php echo $event_scheduled; ?>"
                               required>
                        <div class="invalid-feedback">
                            <?php echo $scheduledMsg; ?>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Create Event</button>

            </form>
        </div>
    </div>
</div>

<?php include VIEWS_DIR . 'bottom.php'; ?>