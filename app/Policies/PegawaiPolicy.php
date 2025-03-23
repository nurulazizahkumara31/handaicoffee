<?namespace App\Policies;

use App\Models\User;
use App\Models\pegawai;
use Illuminate\Auth\Access\Response;

class PegawaiPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Sesuaikan dengan aturan akses Anda
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, pegawai $pegawai): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }
}
