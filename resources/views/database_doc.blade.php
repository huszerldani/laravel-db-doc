{{ ucfirst($database) }}
=

{{ date("Y-m-d") }}

@foreach($tables as $table)
@if($table['comment'])
## {{ $table['comment'] }}

> {{ $table['name'] }}
@else
## {{ $table['name'] }}
@endif

Key | Comment | Column | Data type | Null | Extra
:---: | --- | --- | --- | :---: | :---:
@foreach($table['columns'] as $column)
 {{ ($column->Key === '') ? ' . ' : $column->Key }} | {{ ($column->Comment === '') ? ' . ' : $column->Comment }} | {{ $column->Field }} | {{ ($column->Type === '') ? ' . ' : $column->Type }} | {{ ($column->Null === 'YES') ? '✔️' : ' . ' }} | {{ ($column->Extra === 'auto_increment') ? 'AI' : $column->Extra }} |
@endforeach

@if($table['indexes'])
#### Indexes for {{ $table['name'] }}

Column | Key name | Unique | Comment | Null |
--- | --- | :---: | --- | :---:
@foreach($table['indexes'] as $index)
 {{ ($index->Column_name === '') ? ' . ' : $index->Column_name }} | {{ $index->Key_name }} | {{ ($index->Non_unique === 0) ? '✔' : ' . ' }} | {{ ($index->Index_comment === '') ? ' . ' : $index->Index_comment }} | {{ ($index->Null === 'YES') ? '✔' : ' . ' }} |
@endforeach
@endif
---
<br />

@endforeach
