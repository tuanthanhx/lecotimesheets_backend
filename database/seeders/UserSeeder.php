<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('123456'),
            'group' => 6,
            'hourly_rate' => 25.00,
            'dob' => '1985-01-01',
            'address' => '4001 Anderson Road, Auckland, NZ',
            'phone' => '021 456 7890',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Nguyễn Văn An',
            'username' => 'test_user_001',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1992-05-10',
            'address' => '12 Queen Street, Auckland, NZ',
            'phone' => '021 456 7890',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Trần Minh Hoàng',
            'username' => 'test_user_002',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1988-03-15',
            'address' => '34 Ponsonby Road, Wellington, NZ',
            'phone' => '022 654 3211',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Lê Văn Tuấn',
            'username' => 'test_user_003',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-06-20',
            'address' => '56 Khyber Pass Road, Christchurch, NZ',
            'phone' => '027 987 6543',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Phạm Quốc Anh',
            'username' => 'test_user_004',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1995-11-25',
            'address' => '78 Victoria Street, Hamilton, NZ',
            'phone' => '020 123 4568',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Hoàng Văn Bình',
            'username' => 'test_user_005',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1985-12-02',
            'address' => '90 Albert Street, Tauranga, NZ',
            'phone' => '021 876 5434',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Đặng Văn Sơn',
            'username' => 'test_user_006',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1993-01-18',
            'address' => '123 Lambton Quay, Wellington, NZ',
            'phone' => '027 432 1875',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Vũ Văn Nam',
            'username' => 'test_user_007',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1989-04-10',
            'address' => '345 Remuera Road, Auckland, NZ',
            'phone' => '022 983 2145',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Bùi Hữu Tùng',
            'username' => 'test_user_008',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1994-08-05',
            'address' => '56 Queen Street, Christchurch, NZ',
            'phone' => '020 657 9834',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Ngô Quang Huy',
            'username' => 'test_user_009',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1986-09-19',
            'address' => '90 Devonport Road, Tauranga, NZ',
            'phone' => '027 867 3452',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Đỗ Xuân Thịnh',
            'username' => 'test_user_010',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1992-02-12',
            'address' => '123 Victoria Street, Hamilton, NZ',
            'phone' => '021 987 1254',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Phan Thanh Phong',
            'username' => 'test_user_011',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-10-21',
            'address' => '456 Willis Street, Wellington, NZ',
            'phone' => '022 453 7864',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Nguyễn Hữu Đức',
            'username' => 'test_user_012',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1991-11-30',
            'address' => '789 Colombo Street, Christchurch, NZ',
            'phone' => '020 215 6543',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Trần Văn Lâm',
            'username' => 'test_user_013',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1984-07-04',
            'address' => '678 Lambton Quay, Auckland, NZ',
            'phone' => '027 543 2311',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Lê Quang Hải',
            'username' => 'test_user_014',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1997-03-13',
            'address' => '234 Khyber Pass Road, Wellington, NZ',
            'phone' => '021 453 9087',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Phạm Minh Long',
            'username' => 'test_user_015',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1983-12-01',
            'address' => '345 Ponsonby Road, Tauranga, NZ',
            'phone' => '022 876 5412',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Hoàng Văn Tùng',
            'username' => 'test_user_016',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1996-06-08',
            'address' => '456 Queen Street, Christchurch, NZ',
            'phone' => '027 234 8712',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Đặng Quốc Đạt',
            'username' => 'test_user_017',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1998-05-22',
            'address' => '678 Victoria Street, Hamilton, NZ',
            'phone' => '021 128 7543',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Vũ Hữu Phúc',
            'username' => 'test_user_018',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1982-04-30',
            'address' => '12 Albert Street, Auckland, NZ',
            'phone' => '022 546 9871',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Bùi Văn Thái',
            'username' => 'test_user_019',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1994-09-14',
            'address' => '34 Devonport Road, Tauranga, NZ',
            'phone' => '027 786 4521',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Ngô Văn Khoa',
            'username' => 'test_user_020',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1989-02-28',
            'address' => '56 Lambton Quay, Wellington, NZ',
            'phone' => '020 876 5430',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Đỗ Văn Mạnh',
            'username' => 'test_user_021',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1992-11-09',
            'address' => '78 Colombo Street, Christchurch, NZ',
            'phone' => '021 341 2987',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Phan Hữu Cường',
            'username' => 'test_user_022',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-07-16',
            'address' => '123 Remuera Road, Auckland, NZ',
            'phone' => '022 453 9082',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Nguyễn Văn Hải',
            'username' => 'test_user_023',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1991-12-07',
            'address' => '345 Queen Street, Wellington, NZ',
            'phone' => '027 987 5431',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Trần Văn Quân',
            'username' => 'test_user_024',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1985-06-11',
            'address' => '456 Victoria Street, Tauranga, NZ',
            'phone' => '020 654 3451',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Lê Văn Bảo',
            'username' => 'test_user_025',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1987-08-19',
            'address' => '678 Khyber Pass Road, Hamilton, NZ',
            'phone' => '021 908 7654',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Phạm Hữu Hoàng',
            'username' => 'test_user_026',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1993-10-03',
            'address' => '789 Albert Street, Auckland, NZ',
            'phone' => '022 987 5412',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Hoàng Văn Minh',
            'username' => 'test_user_027',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1994-03-25',
            'address' => '12 Ponsonby Road, Christchurch, NZ',
            'phone' => '027 345 9087',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Đặng Quang Khải',
            'username' => 'test_user_028',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1988-01-14',
            'address' => '34 Devonport Road, Tauranga, NZ',
            'phone' => '020 543 8765',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Vũ Minh Nhật',
            'username' => 'test_user_029',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1995-09-22',
            'address' => '56 Queen Street, Wellington, NZ',
            'phone' => '021 675 4321',
            'language' => 'en',
            'status' => 1,
        ]);
        User::create([
            'name' => 'Bùi Văn Trung',
            'username' => 'test_user_030',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1989-04-11',
            'address' => '78 Colombo Street, Hamilton, NZ',
            'phone' => '022 321 9876',
            'language' => 'en',
            'status' => 1,
        ]);
    }
}
