<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class InvoiceFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $method = $this->route()?->getActionMethod();

        return Arr::get([
            'issue' => self::issue(),
            'cancel' => self::cancel()
        ], $method, []);
    }

    private static function issue(): array
    {
        return  [
            'ID' => 'required|integer',
            'url_notificacao' => 'required|url',
            'operacao' => 'required|integer',
            'natureza_operacao' => 'required|string',
            'modelo' => 'required|integer',
            'finalidade' => 'required|integer',
            'ambiente' => 'required|integer',
            'cliente.cpf' => 'required|string|max:100',
            'cliente.nome_completo' => 'required|string',
            'cliente.endereco' => 'required|string',
            'cliente.complemento' => 'required|string',
            'cliente.numero' => 'required|integer',
            'cliente.bairro' => 'required|string',
            'cliente.cidade' => 'required|string|max:150',
            'cliente.uf' => 'required|string|max:2',
            'cliente.cep' => 'required|string|max:12',
            'cliente.telefone' => 'required|string|max:20',
            'cliente.email' => 'required|string|email|max:255',
            'produtos.*.nome' => 'required|string|max:255',
            'produtos.*.codigo' => 'required|string|max:100',
            'produtos.*.ncm' => 'required|string|max:100',
            'produtos.*.cest' => 'required|string|max:100',
            'produtos.*.quantidade' => 'required|integer',
            'produtos.*.unidade' => 'required|string|max:4',
            'produtos.*.peso' => 'required|string|max:50',
            'produtos.*.origem' => 'required|integer',
            'produtos.*.subtotal' => 'required|string',
            'produtos.*.total' => 'required|string',
            'produtos.*.classe_imposto' => 'required|string|max:120',
            'pedido.pagamento' => 'required|integer',
            'pedido.presenca' => 'required|integer',
            'pedido.modalidade_frete' => 'required|integer',
            'pedido.frete' => 'required|string',
            'pedido.desconto' => 'required|string',
            'pedido.total' => 'required|string'
        ];
    }

    private static function cancel(): array
    {
        return [
            'chave' => 'required|string',
            'motivo' => 'required|string|max:255',
        ];
    }
}
