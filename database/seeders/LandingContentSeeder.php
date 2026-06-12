<?php

namespace Database\Seeders;

use App\Models\ContactInformation;
use App\Models\FoundationContent;
use App\Models\HistoryEntry;
use App\Models\LandingContent;
use App\Models\LeadershipMember;
use App\Models\TeamUnit;
use Illuminate\Database\Seeder;

class LandingContentSeeder extends Seeder
{
    public function run(): void
    {
        $contents = [
            [
                'section' => 'hero',
                'key' => 'hero-main',
                'title' => 'Himpunan Mahasiswa Teknik Informatika',
                'subtitle' => 'Driving #TechForImpact through Digital Innovation',
                'body' => 'We are more than a community. We are an ecosystem for shaping digital talents who are ready to innovate, collaborate, and create tech solutions that deliver real-world impact, embodying the spirit of impactful science and technology.',
                'button_label' => 'Explore Our Programs',
                'button_url' => '#programs',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'section' => 'about',
                'key' => 'about-main',
                'eyebrow' => 'About us',
                'title' => 'Building the Next Generation of <span>Technologists</span>',
                'body' => 'The Informatics Engineering Student Association (HIMATIF) is the official organization for all Informatics Engineering students at Jakarta Global University. We serve as a hub for personal growth, skill development, professional networking, and creating technology that is both useful and impactful.',
                'sort_order' => 1,
                'is_active' => true,
            ],
        ];

        foreach ($contents as $content) {
            LandingContent::updateOrCreate(
                ['key' => $content['key']],
                $content,
            );
        }

        $historyEntries = [
            [
                'type' => 'faq',
                'title' => 'Who were the key figures in our establishment?',
                'body' => '<p><strong>First Daily Executive Board:</strong><br>Aulia Andhika Pradana (Head of Association) - 2017<br>Bintang Asrorul Hidayat (Vice Head) - 2017<br>Dzikril Muttaqin (Secretary) - 2017<br>Feriyan Rizqi Wijaya (Treasurer) - 2017<br><br><strong>Grand Deliberation ratified by:</strong><br>Victor Van Hauten (Presidium I)<br>Muhammad Qais Abdullah (Presidium II)<br>Achmad Zaelani Oktarosi (Presidium III)</p>',
                'sort_order' => 1,
            ],
            [
                'type' => 'faq',
                'title' => 'What does the HIMATIF logo symbolize?',
                'body' => '<p><strong>Monitor</strong>: Represents the identity of the Informatics Engineering program.<br><strong>Wireless Network</strong>: Symbolizes the Networking specialization.<br><strong>Code Inside Monitor</strong>: Symbolizes the Programming specialization.<br><strong>Digital Seven-Segment Numbers</strong>: Represent our organization\'s founding date.<br><strong>Lightning Bolt</strong>: Acknowledges our history as part of the Electrical Engineering Student Association.<br><strong>HIMATIF & JGU Text</strong>: Signifies our identity and home under Jakarta Global University.<br><strong>Two Black Dots</strong>: Balances our identity between HIMATIF & the JGU Student Executive Board.<br><strong>Inner & Outer Black Circles</strong>: Represent the scope of our association within the greater JGU community.</p>',
                'sort_order' => 2,
            ],
            [
                'type' => 'faq',
                'title' => 'What is the meaning behind the logo\'s colors?',
                'body' => '<p><strong>Green</strong>: Tranquility & Peace.<br><strong>Black</strong>: Firmness & Resolve.<br><strong>Red</strong>: Courage in action and attitude.<br><strong>White</strong>: Sincerity & Purity.<br><strong>Yellow</strong>: Cheerfulness & Joy.<br><strong>Red & White</strong>: Symbolizes the Indonesian flag.</p>',
                'sort_order' => 3,
            ],
            [
                'type' => 'faq',
                'title' => 'What was the main goal for founding HIMATIF?',
                'body' => '<p>The primary goal was to create an organization to serve as a hub for activities and academic information. This was intended to improve the program\'s accreditation and academic system, as well as strengthen relationships between students and faculty through practical labs, study groups, and scientific discussions.</p>',
                'sort_order' => 4,
            ],
            [
                'type' => 'journey',
                'title' => 'The Foundation (2013-2018)',
                'body' => '<p>The journey began when the campus was known as the Jakarta College of Technology (STTJ). Faced with low accreditation, minimal student activities, and a need for better resources, Informatics Engineering students agreed to establish their own association through a series of forums.</p>',
                'sort_order' => 1,
            ],
            [
                'type' => 'journey',
                'title' => 'Independence (2019)',
                'body' => '<p>On May 19, 2019, HIMATIF officially separated from the Electrical Engineering Student Association (HME). This move was initiated by a Student Deliberation held on June 27, 2019, laying the groundwork for a new, independent entity.</p>',
                'sort_order' => 2,
            ],
            [
                'type' => 'journey',
                'title' => 'Official Establishment (2019)',
                'body' => '<p>HIMATIF was officially founded on August 18, 2019, during a Grand Deliberation at the newly renamed Jakarta Institute of Technology and Health (ITKJ). This event ratified our official Statutes/Bylaws (AD/ART) and organizational policies.</p>',
                'sort_order' => 3,
            ],
            [
                'type' => 'journey',
                'title' => 'The Present Era - Ignis Elevatio Cabinet',
                'body' => '<p>Today, under the leadership of the "Ignis Elevatio" cabinet, HIMATIF proudly operates under the banner of Jakarta Global University (JGU), continuing its mission to be a central hub for student activities, academic improvement, and building a strong, innovative community for all Informatics Engineering students.</p>',
                'sort_order' => 4,
            ],
        ];

        foreach ($historyEntries as $entry) {
            HistoryEntry::updateOrCreate(
                ['type' => $entry['type'], 'title' => $entry['title']],
                [...$entry, 'is_active' => true],
            );
        }

        $foundationContents = [
            [
                'type' => 'vision',
                'title' => 'VISION',
                'slug' => 'vision',
                'summary' => 'Empowering Informatics Engineering students through community and innovation.',
                'body' => '<p>Empowering Informatics Engineering students through community and innovation.</p>',
                'image_path' => null,
                'sort_order' => 1,
            ],
            [
                'type' => 'mission',
                'title' => 'MISSION',
                'slug' => 'mission',
                'summary' => 'Building community, developing skills, and creating opportunities through events, training, and partnerships.',
                'body' => '<p>Building community, developing skills, and creating opportunities through events, training, and partnerships.</p>',
                'image_path' => null,
                'sort_order' => 2,
            ],
        ];

        foreach ($foundationContents as $foundation) {
            FoundationContent::updateOrCreate(
                ['slug' => $foundation['slug']],
                [...$foundation, 'is_active' => true],
            );
        }

        $teamUnits = [
            ['name' => 'Head & Vice', 'slug' => 'head-vice', 'subtitle' => 'Core Structure', 'icon' => 'user', 'sort_order' => 1],
            ['name' => 'General Secretary', 'slug' => 'general-secretary', 'subtitle' => 'Administration & Archives', 'icon' => 'file-text', 'sort_order' => 2],
            ['name' => 'General Treasurer', 'slug' => 'general-treasurer', 'subtitle' => 'Financial Management', 'icon' => 'credit-card', 'sort_order' => 3],
            ['name' => 'R&D Department', 'slug' => 'rd-department', 'subtitle' => 'Research & Development', 'icon' => 'code', 'sort_order' => 4],
            ['name' => 'Media & Info Dept', 'slug' => 'media-info-dept', 'subtitle' => 'Media & Information', 'icon' => 'message-square', 'sort_order' => 5],
            ['name' => 'Public Relations', 'slug' => 'public-relations', 'subtitle' => 'External Relations', 'icon' => 'users', 'sort_order' => 6],
            ['name' => 'HRD Department', 'slug' => 'hrd-department', 'subtitle' => 'Human Resources Development', 'icon' => 'award', 'sort_order' => 7],
            ['name' => 'Fundraising', 'slug' => 'fundraising', 'subtitle' => 'Funding & Business', 'icon' => 'shopping-cart', 'sort_order' => 8],
        ];

        foreach ($teamUnits as $unit) {
            TeamUnit::updateOrCreate(
                ['slug' => $unit['slug']],
                [
                    ...$unit,
                    'description' => '<p>Detail konten untuk ' . $unit['name'] . ' dapat dikelola melalui dashboard HIMATIF App.</p>',
                    'is_active' => true,
                ],
            );
        }

        $leadershipMembers = [
            ['name' => 'Yasmin Helmy', 'position' => 'President', 'profile_url' => 'https://www.linkedin.com/in/YasminHelmy', 'sort_order' => 1],
            ['name' => 'Muhammad Raihan Alfaiz', 'position' => 'Vice President', 'profile_url' => 'https://www.linkedin.com/in/raihanalfaiz/', 'sort_order' => 2],
            ['name' => 'Ananda Dwi Cynta', 'position' => 'General Secretary I', 'profile_url' => 'https://www.linkedin.com/in/ananda-dwi-cynta-0a9014375/', 'sort_order' => 3],
            ['name' => 'Nabilah Rasyiqah', 'position' => 'General Secretary II', 'profile_url' => null, 'sort_order' => 4],
            ['name' => 'Adam Rinaldi', 'position' => 'General Treasurer I', 'profile_url' => null, 'sort_order' => 5],
            ['name' => 'Della Nur Cahya', 'position' => 'General Treasurer II', 'profile_url' => null, 'sort_order' => 6],
            ['name' => 'Yosua Immanuel', 'position' => 'Head of R&D Department', 'profile_url' => 'https://www.linkedin.com/in/yosuaimmanuelhk/', 'sort_order' => 7],
            ['name' => 'Muhammad Fadli Taptajani', 'position' => 'Head of Media & Info Department', 'profile_url' => 'https://www.linkedin.com/in/fadli-taptajani/', 'sort_order' => 8],
            ['name' => 'Sarah Ardelia', 'position' => 'Head of Fundraising', 'profile_url' => null, 'sort_order' => 9],
            ['name' => 'Radiva Rizki', 'position' => 'Head of Public Relations', 'profile_url' => null, 'sort_order' => 10],
            ['name' => 'Alvando Lefran', 'position' => 'Head of HRD Department', 'profile_url' => null, 'sort_order' => 11],
        ];

        foreach ($leadershipMembers as $member) {
            LeadershipMember::updateOrCreate(
                ['name' => $member['name'], 'position' => $member['position']],
                [...$member, 'is_active' => true],
            );
        }

        $contacts = [
            [
                'label' => 'Jakarta Global University',
                'type' => 'address',
                'value' => 'Jl. Boulevard Grand Depok City, Tirtajaya, Kec. Sukmajaya, Kota Depok, Jawa Barat 16412',
                'url' => null,
                'sort_order' => 1,
            ],
            [
                'label' => 'Email Address',
                'type' => 'email',
                'value' => 'himatif.19@jgu.ac.id',
                'url' => 'mailto:himatif.19@jgu.ac.id',
                'sort_order' => 2,
            ],
            [
                'label' => 'Phone Number',
                'type' => 'phone',
                'value' => "+62 821-2498-6343\n+62 898-5831-080",
                'url' => null,
                'sort_order' => 3,
            ],
        ];

        foreach ($contacts as $contact) {
            ContactInformation::updateOrCreate(
                ['label' => $contact['label']],
                [...$contact, 'is_active' => true],
            );
        }
    }
}
