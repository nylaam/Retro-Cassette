<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Isi database dengan 1 user demo dan 3 kaset berisi lagu.
     * Aman dijalankan berulang kali: kaset demo lama dihapus dulu.
     *
     * Login demo: demo@retrovibe.test / password
     */
    public function run(): void
    {
        $demo = User::updateOrCreate(
            ['email' => 'demo@retrovibe.test'],
            ['name' => 'Demo', 'password' => 'password'],
        );

        $demo->cassettes()->delete();

        foreach ($this->dataKaset() as $data) {
            $daftarLagu = $data['lagu'];
            unset($data['lagu']);

            $kaset = $demo->cassettes()->create($data);
            $kaset->tracks()->createMany($daftarLagu);
        }
    }

    private function dataKaset(): array
    {
        return [
            [
                'title' => 'Lagu Galau',
                'color' => 'coral',
                'note' => 'Buat hari hujan',
                'visibility' => 'private',
                'lagu' => [
                    $this->lagu('Someone Like You', 'Adele', 285, 'hLQl3WQQoQ0', 'A', 0),
                    $this->lagu('Hello', 'Adele', 367, 'YQHsXMglC9A', 'A', 1),
                    $this->lagu('Fix You', 'Coldplay', 295, 'k4V3Mo61fJM', 'B', 0),
                    $this->lagu('Let Her Go', 'Passenger', 253, 'RBumgq5yVrA', 'B', 1),
                ],
            ],
            [
                'title' => 'Semangat Pagi',
                'color' => 'teal',
                'note' => 'Teman sarapan',
                'visibility' => 'private',
                'lagu' => [
                    $this->lagu('Happy', 'Pharrell Williams', 233, 'ZbZSe6N_BXs', 'A', 0),
                    $this->lagu('Uptown Funk', 'Mark Ronson', 270, 'OPf0YbXqDm0', 'A', 1),
                    $this->lagu("Can't Stop the Feeling!", 'Justin Timberlake', 237, 'ru0K8uYEZWw', 'B', 0),
                    $this->lagu('Roar', 'Katy Perry', 270, 'CevxZvSJLk8', 'B', 1),
                ],
            ],
            [
                'title' => 'Road Trip',
                'color' => 'mustard',
                'note' => 'Nyanyi bareng di mobil',
                'visibility' => 'public',
                'lagu' => [
                    $this->lagu('Bohemian Rhapsody', 'Queen', 355, 'fJ9rUzIMcZQ', 'A', 0),
                    $this->lagu("Don't Stop Believin'", 'Journey', 251, '1k8craCGpgs', 'A', 1),
                    $this->lagu('Eye of the Tiger', 'Survivor', 246, 'btPJPFnesV4', 'A', 2),
                    $this->lagu('See You Again', 'Wiz Khalifa', 237, 'RgKAFK5djSk', 'B', 0),
                    $this->lagu('Sugar', 'Maroon 5', 302, '09R8_2nJtjg', 'B', 1),
                ],
            ],
        ];
    }

    // Satu lagu. source_id = ID video YouTube. Durasi perkiraan (detik).
    private function lagu(string $judul, string $artis, int $durasi, string $youtubeId, string $sisi, int $urutan): array
    {
        return [
            'title' => $judul,
            'artist' => $artis,
            'duration_sec' => $durasi,
            'source_type' => 'youtube',
            'source_id' => $youtubeId,
            'side' => $sisi,
            'position' => $urutan,
        ];
    }
}
