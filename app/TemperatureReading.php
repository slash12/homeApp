<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemperatureReading extends Model
{
    /**
     * Connection name for this model
     *
     * @var string
     */
    protected $connection = 'tempReafdingCon';

    /**
     * Table Name
     *
     * @var string
     */
    protected $table = 'temperatureReadings';

    /**
     * primary key associated
     * 
     * @var string
     */
    protected $primaryKey = 'tempReading_id';

    /**
     * Auto increment on each insert
     *
     * @var boolean
     */
    public $incrementing = true;

    /**
     * Add a created_at and updated_at columns
     *
     * @var boolean
     */
    public $timestamps = true;

    protected $attributes = [
        'tempMax' => 0,
        'tempMin' => 0
    ];
}
