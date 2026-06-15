<?php

namespace Tests\Unit;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class DeleteOrConflictResponseTest extends TestCase
{
    public function test_delete_or_conflict_returns_conflict_for_foreign_key_errors(): void
    {
        $controller = new class extends Controller
        {
            public function delete(Model $model)
            {
                return $this->deleteOrConflict(
                    $model,
                    'Deleted',
                    'Cannot delete record because it is being used.'
                );
            }
        };

        $model = new class extends Model
        {
            public function delete()
            {
                throw new QueryException(
                    'testing',
                    'delete from users where id = ?',
                    [1],
                    new Exception('Integrity constraint violation', 23000)
                );
            }
        };

        $response = $controller->delete($model);

        $this->assertSame(409, $response->getStatusCode());
        $this->assertSame(
            ['message' => 'Cannot delete record because it is being used.'],
            $response->getData(true)
        );
    }
}
