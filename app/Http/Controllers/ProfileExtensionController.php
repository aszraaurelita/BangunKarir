<?php

namespace App\Http\Controllers;

use App\Models\{
    OrganizationalExperience,
    Project,
    WorkExperience,
    UserSkill,
    Certificate,
    Achievement,
    Portfolio,
    User
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileExtensionController extends Controller
{
    public function index()
    {
        try {
            /** @var User $user */
            $user = Auth::user();
            
            // Load relasi dengan explicit method calls
            $user->load([
                'organizationalExperiences',
                'projects',
                'workExperiences', 
                'skills',
                'certificates',
                'achievements',
                'portfolios'
            ]);

            $skillRecommendations = UserSkill::getSkillRecommendations();

            return view('profile.extension.index', compact('user', 'skillRecommendations'));

        } catch (\Exception $e) {
            Log::error('Error loading profile extension', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('profile.show')
                ->with('error', 'Terjadi kesalahan saat memuat halaman. Silakan coba lagi.');
        }
    }

    // Pengalaman Organisasi
    public function storeOrganization(Request $request)
    {
        try {
            $request->validate([
                'nama_organisasi' => 'required|string|max:255',
                'jabatan' => 'required|string|max:255',
                'tanggal_masuk' => 'required|date',
                'tanggal_selesai' => 'nullable|date|after:tanggal_masuk',
                'deskripsi_kegiatan' => 'required|string|max:1000',
            ]);

            OrganizationalExperience::create([
                'user_id' => Auth::id(),
                'nama_organisasi' => $request->nama_organisasi,
                'jabatan' => $request->jabatan,
                'tanggal_masuk' => $request->tanggal_masuk,
                'tanggal_selesai' => $request->tanggal_selesai,
                'deskripsi_kegiatan' => $request->deskripsi_kegiatan,
            ]);

            return back()->with('success', 'Pengalaman organisasi berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Error storing organization', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    // Proyek
    public function storeProject(Request $request)
    {
        try {
            $request->validate([
                'nama_proyek' => 'required|string|max:255',
                'deskripsi_proyek' => 'required|string|max:1000',
                'tanggal_pelaksanaan' => 'required|date',
                'tautan' => 'nullable|url',
            ]);

            Project::create([
                'user_id' => Auth::id(),
                'nama_proyek' => $request->nama_proyek,
                'deskripsi_proyek' => $request->deskripsi_proyek,
                'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
                'tautan' => $request->tautan,
            ]);

            return back()->with('success', 'Proyek berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Error storing project', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    // Work Experience
    public function storeWorkExperience(Request $request)
    {
        try {
            $request->validate([
                'nama_perusahaan' => 'required|string|max:255',
                'posisi' => 'required|string|max:255',
                'deskripsi_kerja' => 'required|string|max:1000',
                'lama_waktu' => 'required|string|max:255',
            ]);

            WorkExperience::create([
                'user_id' => Auth::id(),
                'nama_perusahaan' => $request->nama_perusahaan,
                'posisi' => $request->posisi,
                'deskripsi_kerja' => $request->deskripsi_kerja,
                'lama_waktu' => $request->lama_waktu,
            ]);

            return back()->with('success', 'Pengalaman kerja berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Error storing work experience', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    // Skills
    public function storeSkill(Request $request)
    {
        try {
            $request->validate([
                'skills' => 'required|array',
                'skills.*' => 'required|string|max:255',
                'tipe' => 'required|in:soft_skill,hard_skill',
            ]);

            foreach ($request->skills as $skill) {
                UserSkill::firstOrCreate([
                    'user_id' => Auth::id(),
                    'nama_skill' => $skill,
                    'tipe' => $request->tipe,
                ]);
            }

            return back()->with('success', 'Skills berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Error storing skills', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    // Certificate
    public function storeCertificate(Request $request)
    {
        try {
            $request->validate([
                'nama_sertifikat' => 'required|string|max:255',
                'penyelenggara' => 'required|string|max:255',
                'tahun' => 'required|integer|min:2000|max:' . date('Y'),
                'deskripsi' => 'nullable|string|max:1000',
                'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            ]);

            $data = [
                'user_id' => Auth::id(),
                'nama_sertifikat' => $request->nama_sertifikat,
                'penyelenggara' => $request->penyelenggara,
                'tahun' => $request->tahun,
                'deskripsi' => $request->deskripsi,
            ];

            if ($request->hasFile('file_sertifikat')) {
                $filePath = $request->file('file_sertifikat')->store('certificates', 'public');
                $data['file_sertifikat'] = $filePath;
            }

            Certificate::create($data);

            return back()->with('success', 'Sertifikat berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Error storing certificate', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    // Achievement
    public function storeAchievement(Request $request)
    {
        try {
            $request->validate([
                'nama_penghargaan' => 'required|string|max:255',
                'penyelenggara' => 'required|string|max:255',
                'tahun' => 'required|integer|min:2000|max:' . date('Y'),
                'deskripsi' => 'nullable|string|max:1000',
            ]);

            Achievement::create([
                'user_id' => Auth::id(),
                'nama_penghargaan' => $request->nama_penghargaan,
                'penyelenggara' => $request->penyelenggara,
                'tahun' => $request->tahun,
                'deskripsi' => $request->deskripsi,
            ]);

            return back()->with('success', 'Penghargaan berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Error storing achievement', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    // Portfolio
    public function storePortfolio(Request $request)
    {
        try {
            $request->validate([
                'jenis' => 'required|in:teks,gambar,video',
                'deskripsi' => 'required|string|max:1000',
                'file_portfolio' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:10240',
            ]);

            $data = [
                'user_id' => Auth::id(),
                'jenis' => $request->jenis,
                'deskripsi' => $request->deskripsi,
            ];

            if ($request->hasFile('file_portfolio')) {
                $filePath = $request->file('file_portfolio')->store('portfolios', 'public');
                $data['file_path'] = $filePath;
            }

            Portfolio::create($data);

            return back()->with('success', 'Portfolio berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Error storing portfolio', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    // Delete methods
    public function deleteOrganization($id)
    {
        try {
            $org = OrganizationalExperience::where('user_id', Auth::id())->findOrFail($id);
            $org->delete();
            return back()->with('success', 'Pengalaman organisasi berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function deleteProject($id)
    {
        try {
            $project = Project::where('user_id', Auth::id())->findOrFail($id);
            $project->delete();
            return back()->with('success', 'Proyek berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function deleteWorkExperience($id)
    {
        try {
            $work = WorkExperience::where('user_id', Auth::id())->findOrFail($id);
            $work->delete();
            return back()->with('success', 'Pengalaman kerja berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function deleteSkill($id)
    {
        try {
            $skill = UserSkill::where('user_id', Auth::id())->findOrFail($id);
            $skill->delete();
            return back()->with('success', 'Skill berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function deleteCertificate($id)
    {
        try {
            $cert = Certificate::where('user_id', Auth::id())->findOrFail($id);
            if ($cert->file_sertifikat) {
                Storage::disk('public')->delete($cert->file_sertifikat);
            }
            $cert->delete();
            return back()->with('success', 'Sertifikat berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function deleteAchievement($id)
    {
        try {
            $achievement = Achievement::where('user_id', Auth::id())->findOrFail($id);
            $achievement->delete();
            return back()->with('success', 'Penghargaan berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function deletePortfolio($id)
    {
        try {
            $portfolio = Portfolio::where('user_id', Auth::id())->findOrFail($id);
            if ($portfolio->file_path) {
                Storage::disk('public')->delete($portfolio->file_path);
            }
            $portfolio->delete();
            return back()->with('success', 'Portfolio berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

}
