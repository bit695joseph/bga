(function () {
    jQuery(function ($) {
        $("button.games-btn").on("click", navigateToMemberGamesPage);
    });

    function navigateToMemberGamesPage() {
        window.location.href = BgaApp.url('edit_member_games.php', getParams(this));
    }

    function getParams(btn) {
        return {
            'member_id': $(btn).closest('tr').attr('id')
        };
    }
})();