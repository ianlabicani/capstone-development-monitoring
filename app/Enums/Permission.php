<?php

namespace App\Enums;

enum Permission: string
{
    case ViewDashboard = 'view dashboard';
    case ManageSystem = 'manage system';
    case ManageUsers = 'manage users';
    case ViewTeamProgress = 'view team progress';
    case ViewCommitActivity = 'view commit activity';
    case ViewBranchActivity = 'view branch activity';
    case ViewPullRequests = 'view pull requests';
    case ViewContributors = 'view contributors';
    case ManageTeams = 'manage teams';
    case ManageTeamLeaders = 'manage team leaders';
    case RegisterRepository = 'register repository';
    case ManageRepository = 'manage repository';
}
