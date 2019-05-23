let playerStaticUrl = '/recruitment/players';
let teamStaticUrl = '/recruitment/teams';
let delimiter = ',';
$("#filter_players").change(function() {
    let query = $(this)
    // Create array
        .serializeArray()
        // Group array by key name
        .reduce(function(grouped, field) {
            grouped[field.name] = grouped[field.name] || [];
            grouped[field.name].push(field.value);
            return grouped;
        }, {});

    // Build query string
    let queryString = $
        .map(query, function(values, name) {
            return name + '=' + values.join(delimiter);
        })
        .join('&');

    // Build URL
    let url = queryString ? playerStaticUrl + '?' + queryString : playerStaticUrl;

    if (history.pushState) {
        let new_url = window.location.protocol + "//" + window.location.host + url;
        window.history.pushState({path:new_url}, '', new_url);
    }

    $.request('onFilterPlayers', {
        update: { 'cleanseRecruitmentListPlayers::_player_list': '#playerlist' }
    }); return false;
});

$("#filter_teams").change(function() {
    let query = $(this)
    // Create array
        .serializeArray()
        // Group array by key name
        .reduce(function(grouped, field) {
            grouped[field.name] = grouped[field.name] || [];
            grouped[field.name].push(field.value);
            return grouped;
        }, {});

    // Build query string
    let queryString = $
        .map(query, function(values, name) {
            return name + '=' + values.join(delimiter);
        })
        .join('&');

    // Build URL
    let url = queryString ? teamStaticUrl + '?' + queryString : teamStaticUrl;

    if (history.pushState) {
        let new_url = window.location.protocol + "//" + window.location.host + url;
        window.history.pushState({path:new_url}, '', new_url);
    }

    $.request('onFilterTeams', {
        update: { 'cleanseRecruitmentListTeams::_team_list': '#teamlist' }
    }); return false;
});