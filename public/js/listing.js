(function () {

    var modelLabel = BgaData.pageData.model,
        modelName = modelLabel.toLowerCase(),
        modelIdField = modelName + "_id",
        editPhpFile = 'edit_' + modelName + '.php',
        createPhpFile = 'create_' + modelName + '.php',
        deletePhpFile = 'delete_' + modelName + '.php';

    jQuery(function ($) {
        // common
        $("button.create-btn").on("click", navigateToCreatePage);
        $("button.edit-btn").on("click", navigateToEditPage);
        $("button.delete-btn").on("click", requestDelete);
        // members listingn
        $("button.games-btn").on("click", navigateToMemberGamesPage);

        setupMemberGames();
    });

    function navigateToCreatePage() {
        window.location.href = BgaApp.url(createPhpFile);
    }

    function navigateToEditPage() {
        window.location.href = BgaApp.url(editPhpFile, getParams(this));
    }

    function navigateToMemberGamesPage() {
        window.location.href = BgaApp.url('edit_member_games.php', getParams(this));
    }


    function defaultFail() {

    }



    function requestDelete() {

        var btn = this;

        if (!confirm("Delete " + modelLabel + "?"))
            return;

        // Make delete request.
        $.post(
            BgaApp.ajaxUrl(deletePhpFile),
            getParams(this),
            function () {
                $(btn).closest('tr').fadeOut();
            })
            .fail(function () {
                alert("There were errors");
                console.log("fail", arguments);
            });
    }

    function getParams(btn) {
        var p = {};
        p[modelIdField] = $(btn).closest('tr').attr('id');
        return p;
    }

    function setupMemberGames()
    {
        $("input.game-toggle").change(function() {

            var $gameCheckbox = $(this);

            var script = $gameCheckbox.is(':checked')
                ? "add_game_to_member.php"
                : "remove_game_from_member.php";
            $.post(
                BgaApp.ajaxUrl(script),
                {
                    member_id : $gameCheckbox.data('member'),
                    game_id : $gameCheckbox.data('game')
                },
                function () {
                    console.log('success', arguments);
                })
                .fail(defaultFail);

        });
    }



})();
