<?php echo '<?php' ?>

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Setting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Create the Settings Table
         *
         */
        Schema::create('{{ $setting['tables']['settings'] }}', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')
                ->nullable();
            $table->text('value')
                ->nullable();

            $table->index('key', 'settings_index');
        });


        /**
         * DB Log of Changes
         *
         */
        Schema::create('{{ $setting['tables']['settings_log'] }}', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')
                ->default('0');
            $table->integer('setting_id')
                ->default('0');
            $table->text('previous');
            $table->timestamp('created_at')
                ->useCurrent();

            $table->index('user_id', 'settings_log_user_id_index');
            $table->index('setting_id', 'settings_log_setting_id_index');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('{{ $setting['tables']['settings'] }}');
        Schema::drop('{{ $setting['tables']['settings_log'] }}');
    }
}