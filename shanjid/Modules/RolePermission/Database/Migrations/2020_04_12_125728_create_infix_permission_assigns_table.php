<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\InfixModuleInfo;
use Modules\RolePermission\Entities\InfixModuleStudentParentInfo;
use Modules\RolePermission\Entities\InfixPermissionAssign;

class CreateInfixPermissionAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infix_permission_assigns', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();
            $table->integer('module_id')->nullable()->comment(' module id, module link id, module link options id');
            $table->string('module_info')->nullable();
            $table->integer('role_id')->nullable()->unsigned();
            $table->foreign('role_id')->references('id')->on('infix_roles')->onDelete('cascade');
            $table->text('saas_schools')->nullable();
            $table->integer('created_by')->nullable()->default(1)->unsigned();
            $table->integer('updated_by')->nullable()->default(1)->unsigned();
            $table->integer('school_id')->nullable()->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');
        });


        
        $admins = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 79, 80, 81, 82, 83, 84, 85, 86, 533, 534, 535, 536, 87, 88, 89, 90, 91, 92, 93, 94, 95, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131, 132, 133, 134, 135, 160, 161, 162, 163, 164, 165, 166, 167, 168, 169, 170, 171, 172, 173, 174, 175, 176, 177, 178, 179, 180, 181, 182, 183, 184, 185, 186, 187, 188, 189, 190, 191, 192, 193, 194, 195, 196, 197, 198, 199, 200, 201, 202, 203, 204, 205, 206, 207, 208, 209, 210, 211, 214, 215, 216, 217, 218, 219, 225, 226, 227, 228, 229, 230, 231, 232, 233, 234, 235, 236, 237, 238, 239, 240, 241, 242, 243, 244, 245, 246, 247, 248, 249, 250, 251, 252, 253, 254, 255, 256, 257, 258, 259, 260, 261, 262, 263, 264, 265, 266, 267, 268, 269, 270, 271, 272, 273, 274, 275, 276, 537, 286, 287, 288, 289, 290, 291, 292, 293, 294, 295, 296, 297, 298, 299, 300, 301, 302, 303, 304, 305, 306, 307, 308, 309, 310, 311, 312, 313, 314, 315, 316, 317, 318, 319, 320, 321, 322, 323, 324, 325, 326, 327, 328, 329, 330, 331, 332, 333, 334, 335, 336, 337, 338, 339, 340, 341, 342, 343, 344, 345, 346, 347, 348, 349, 350, 351, 352, 353, 354, 355, 356, 357, 358, 359, 360, 361, 362, 363, 364, 365, 366, 367, 368, 369, 370, 371, 372, 373, 374, 375, 376, 377, 378, 379, 380, 381, 382, 383, 384, 385, 386, 387, 388, 389, 390, 391, 392, 394, 395, 396, 397, 538, 539, 540, 485, 486, 487, 488, 489, 490, 491,553,577,800,801,802,803,804,805,806,807,808,809,810,811,812,813,814,815,900,901,902,903,904];

        foreach ($admins as $key => $value) {

            $permission = new InfixPermissionAssign();
            $permission->module_id = $value;
            $permission ->module_info = InfixModuleInfo::find($value)->name;
            $permission->role_id = 5;
            $permission->save();
        }

        // for teacher
        $teachers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 79, 80, 81, 82, 83, 84, 85, 86, 533, 534, 535, 536, 87, 88, 89, 90, 91, 92, 93, 94, 95, 100, 101, 102, 103, 104, 105, 106, 107, 160, 161, 162, 163, 164, 165, 166, 167, 168, 169, 170, 171, 172, 173, 174, 175, 176, 177, 178, 179, 180, 181, 182, 183, 184, 185, 186, 187, 188, 189, 190, 191, 192, 193, 194, 195, 196, 197, 198, 199, 200, 201, 202, 203, 204, 205, 206, 207, 208, 209, 210, 211, 214, 215, 216, 217, 218, 219, 225, 226, 227, 228, 229, 230, 231, 232, 233, 234, 235, 236, 237, 238, 239, 240, 241, 242, 243, 244, 245, 246, 247, 248, 249, 250, 251, 252, 253, 254, 255, 256, 257, 258, 259, 260, 261, 262, 263, 264, 265, 266, 267, 268, 269, 270, 271, 272, 273, 274, 275, 276, 537, 286, 287, 288, 289, 290, 291, 292, 293, 294, 295, 296, 297, 298, 299, 300, 301, 302, 303, 304, 305, 306, 307, 308, 309, 310, 311, 312, 313, 314, 348, 349, 350, 351, 352, 353, 354, 355, 356, 357, 358, 359, 360, 361, 362, 363, 364, 365, 366, 367, 368, 369, 370, 371, 372, 373, 374, 375, 277, 278, 279, 280, 281, 282, 283, 284, 285,553,800,801,802,803,804,805,806,807,808,809,833,834,900,901,902,903,904];

        foreach ($teachers as $key => $value) {
            $permission = new InfixPermissionAssign();
            $permission->module_id = $value;
            $permission ->module_info = InfixModuleInfo::find($value)->name;
            $permission->role_id = 4;
            $permission->save();
        }

        // for receiptionists
        $receiptionists = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 64, 65, 66, 67, 83, 84, 85, 86, 160, 161, 162, 163, 164, 188, 193, 194, 195, 376, 377, 378, 379, 380,553, 900,901,902,903,904];
        foreach ($receiptionists as $key => $value) {
            $permission = new InfixPermissionAssign();
            $permission->module_id = $value;
            $permission ->module_info = InfixModuleInfo::find($value)->name;
            $permission->role_id = 7;
            $permission->save();
        }

        // for librarians
        $librarians = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 61, 64, 65, 66, 67, 83, 84, 85, 86, 160, 161, 162, 163, 164, 188, 193, 194, 195, 298, 299, 300, 301, 302, 303, 304, 305, 306, 307, 308, 309, 310, 311, 312, 313, 314, 376, 377, 378, 379, 380,553,900,901,902,903,904];
        foreach ($librarians as $key => $value) {
            $permission = new InfixPermissionAssign();
            $permission->module_id = $value;
            $permission ->module_info = InfixModuleInfo::find($value)->name;
            $permission->role_id = 8;
            $permission->save();
        }

        // for drivers
        $drivers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 188, 193, 194, 19,553,900,901,902,903,904];
        foreach ($drivers as $key => $value) {
            $permission = new InfixPermissionAssign();
            $permission->module_id = $value;
            $permission ->module_info = InfixModuleInfo::find($value)->name;
            $permission->role_id = 9;
            $permission->save();
        }

        // for accountants
        $accountants = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 64, 65, 66, 67, 68, 69, 70, 83, 84, 85, 86, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131, 132, 133, 134, 135, 160, 161, 162, 163, 164, 165, 166, 167, 168, 169, 170, 171, 172, 173, 174, 175, 176, 177, 178, 179, 188, 193, 194, 195, 376, 377, 378, 379, 380, 381, 382, 383,553,900,901,902,903,904];

        foreach ($accountants as $key => $value) {
            $permission = new InfixPermissionAssign();
            $permission->module_id = $value;
            $permission ->module_info = InfixModuleInfo::find($value)->name;
            $permission->role_id = 6;
            $permission->save();
        }

        // student
        for ($j = 1; $j <= 55; $j++) {
            $permission = new InfixPermissionAssign();
            $permission->module_id = $j;
            $permission ->module_info = InfixModuleInfo::find($value)->name;
            $permission->role_id = 2;
            $permission->save();
        }

    

        //  Student for Chat Module

        $students = [900,901,902,903,904];
        foreach ($students as $key => $value) {
            $permission = new InfixPermissionAssign();
            $permission->module_id = $value;
            $permission ->module_info = InfixModuleInfo::find($value)->name;
            $permission->role_id = 2;
            $permission->save();
        }

        $students = [800,810,815,1124,1125,1126,1156];
            foreach ($students as $key => $value) {
            $permission = new InfixPermissionAssign();
            $permission->module_id = $value;
            $permission ->module_info = @InfixModuleInfo::find($value)->name;
            $permission->role_id = 2;
            $permission->save();
        }

        // parent
        for ($j = 56; $j <= 99; $j++) {
            $permission = new InfixPermissionAssign();
            $permission->module_id = $j;
            $permission ->module_info = @InfixModuleInfo::find($value)->name;
            $permission->role_id = 3;
            $permission->save();
        }

        // Parent for Online Exam

        $parents = [2016,2017,2018,1127,1128,1129,1157];
        foreach ($parents as $key => $value) {
            $permission = new InfixPermissionAssign();
            $permission->module_id = $value;
            $permission ->module_info = @InfixModuleInfo::find($value)->name;
            $permission->role_id = 3;
            $permission->save();
        }
        // Parent for Chat Module

        $parents = [910,911,912,913,914];
        foreach ($parents as $key => $value) {
            $permission = new InfixPermissionAssign();
            $permission->module_id = $value;
            $permission ->module_info = @InfixModuleInfo::find($value)->name;
            $permission->role_id = 3;
            $permission->save();
        }

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('infix_permission_assigns');
    }
}
