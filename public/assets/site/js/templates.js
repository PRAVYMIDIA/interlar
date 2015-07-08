/*jshint multistr: true */

var template_produtos = '{{#data}}\
        <div class="col-sm-6 col-md-4 item-produto">\
          <div class="thumbnail thumbnail-custom">\
            <a href="/produtos/{{produto_slug}}/{{ id }}">\
              <img src="{{mini}}" alt="{{nome}}">\
            </a>\
          </div>\
            {{#parcelas}}\
                <img src="/assets/site/images/tag-{{parcelas}}-parcelas.png" class="tag-parcela" />\
            {{/parcelas}}\
            <div class="caption" style="text-align: center;">\
              <span class="captionproduto">{{nome}}\
                {{#fornecedor_nome}}\
                &nbsp;-&nbsp; {{fornecedor_nome}} \
                {{/fornecedor_nome}}\
                {{#valor}}\
                    {{#valor_promocional}}\
                        <span style="text-decoration:line-through;">De: R$ {{valor}} </span>\
                        <span>por apenas: </span>\
                        <span>R$</span><span style="color:red; font-size:20px;">{{valor_promocional}}</span>\
                    {{/valor_promocional}}\
                    \
                    {{^valor_promocional}}\
                        <span>R$</span><span style="color:red; font-size:20px;">{{valor}}</span>\
                    {{/valor_promocional}}\
                {{/valor}}\
                {{#parcelas}}\
                    <span> em até {{ parcelas }}x s/Juros</span>\
                {{/parcelas}}\
              </span>\
            </div>\
        </div>\
        {{/data}}';