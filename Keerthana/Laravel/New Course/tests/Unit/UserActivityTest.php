<?php

namespace Tests\Unit;

use Mockery;
use App\Models\User;
use App\Enums\ActivityTypeEnum;
use App\Models\UserActivity;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserActivityTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

   public function testCheckIfUserIsFraudReturnsTrueForExcessiveLoginAttempts()
    {
        $user = Mockery::mock(User::class);
        $activities = Mockery::mock(HasMany::class);

        $user->shouldReceive('userActivities')
             ->andReturn($activities);

        $activities->shouldReceive('whereDate->where->count')
                   ->andReturn(6, 1);

        $service = new UserActivity();
        $result = $service->checkIfUserIsFraud($user);

        $this->assertTrue($result);
    }

    public function testCheckIfUserIsFraudReturnsTrueForExcessivePasswordChanges()
    {
        $user = Mockery::mock(User::class);
        $activities = Mockery::mock(HasMany::class);

        $user->shouldReceive('userActivities')
             ->andReturn($activities);

        $activities->shouldReceive('whereDate->where->count')
                   ->andReturn(1, 4);

        $service = new UserActivity();
        $result = $service->checkIfUserIsFraud($user);

        $this->assertTrue($result);
    }

    public function testCheckIfUserIsFraudReturnsFalseForNormalActivity()
    {
        $user = Mockery::mock(User::class);
        $activities = Mockery::mock(HasMany::class);

        $user->shouldReceive('userActivities')
             ->andReturn($activities);

        $activities->shouldReceive('whereDate->where->count')
                   ->andReturn(1, 2);

        $service = new UserActivity();
        $result = $service->checkIfUserIsFraud($user);

        $this->assertFalse($result);
    }

    public function testIncrementLoginCreatesLoginActivity()
    {
        $user = Mockery::mock(User::class);
        $activities = Mockery::mock(HasMany::class);

        $user->shouldReceive('userActivities')
             ->andReturn($activities);

        $expectedType = ActivityTypeEnum::getKey(ActivityTypeEnum::Login);
        $expectedDescription = ActivityTypeEnum::getDescription(ActivityTypeEnum::Login);

        $activities->shouldReceive('create')
                   ->with([
                       'activity_type' => $expectedType,
                       'data' => $expectedDescription,
                   ])
                   ->once()
                   ->andReturn('created');

        $service = new UserActivity();
        $result = $service->incrementLogin($user);

        $this->assertEquals('created', $result);
    }

    public function testIncrementPasswordChangeCreatesPasswordChangeActivity()
    {
        $user = Mockery::mock(User::class);
        $activities = Mockery::mock(HasMany::class);

        $user->shouldReceive('userActivities')
             ->andReturn($activities);

        $expectedType = ActivityTypeEnum::getKey(ActivityTypeEnum::PasswordChange);
        $expectedDescription = ActivityTypeEnum::getDescription(ActivityTypeEnum::PasswordChange);

        $activities->shouldReceive('create')
                   ->with([
                       'activity_type' => $expectedType,
                       'data' => $expectedDescription,
                   ])
                   ->once()
                   ->andReturn('created');

        $service = new UserActivity();
        $result = $service->incrementPasswordChange($user);

        $this->assertEquals('created', $result);
    }



}
