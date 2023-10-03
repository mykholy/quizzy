    public function index({{ $config->modelNames->name }}DataTable ${{ $config->modelNames->camel }}DataTable)
    {
    return ${{ $config->modelNames->camel }}DataTable->render('{{ $config->prefixes->getViewPrefixForInclude() }}{{ $config->modelNames->snakePlural }}.index');
    }
