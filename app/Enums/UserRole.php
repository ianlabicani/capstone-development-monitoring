<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case CapstoneTeacher = 'capstone_teacher';
    case TechnicalAdviser = 'technical_adviser';
    case TeamLeader = 'team_leader';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::CapstoneTeacher => 'Capstone Teacher',
            self::TechnicalAdviser => 'Technical Adviser',
            self::TeamLeader => 'Team Leader',
        };
    }

    /**
     * @return array<int, Permission>
     */
    public function permissions(): array
    {
        return match ($this) {
            self::Admin => Permission::cases(),
            self::CapstoneTeacher => [
                Permission::ViewDashboard,
                Permission::ViewTeamProgress,
                Permission::ViewCommitActivity,
                Permission::ViewBranchActivity,
                Permission::ViewPullRequests,
                Permission::ViewContributors,
                Permission::ManageTeams,
            ],
            self::TechnicalAdviser => [
                Permission::ViewDashboard,
                Permission::ViewTeamProgress,
                Permission::ViewCommitActivity,
                Permission::ViewBranchActivity,
                Permission::ViewPullRequests,
                Permission::ViewContributors,
                Permission::ManageTeamLeaders,
            ],
            self::TeamLeader => [
                Permission::ViewDashboard,
                Permission::ViewCommitActivity,
                Permission::ViewBranchActivity,
                Permission::ViewPullRequests,
                Permission::ViewContributors,
                Permission::RegisterRepository,
                Permission::ManageRepository,
            ],
        };
    }
}
