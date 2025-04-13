<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Company;

return new class extends Migration
{
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('slug')->after('code')->nullable();
        });
        
        // Generate slugs for existing companies
        foreach (Company::all() as $company) {
            $company->update(['slug' => Str::slug($company->name)]);
        }
    }
    
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
