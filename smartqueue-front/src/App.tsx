import { QueueTable } from './components/QueueTable'
import { LayoutDashboard, Mail, Settings, LogOut, BarChart3 } from 'lucide-react'

function App() {
  return (
    <div className="flex min-h-screen bg-slate-950 text-slate-100 font-sans antialiased">
      
      {/* 1. MENU LATERAL COMPACTO (Estilo referência dashboard) */}
      <aside className="w-16 md:w-20 bg-slate-900 border-r border-slate-800 flex flex-col items-center py-6 justify-between shrink-0">
        
        {/* Bloco Superior: Logo e Navegação */}
        <div className="flex flex-col items-center gap-8 w-full">
          {/* Logo .ico da pasta public */}
          <div className="w-10 h-10 md:w-12 md:h-12 rounded-xl overflow-hidden shadow-md shadow-blue-500/10 border border-slate-700 p-1 bg-slate-950 flex items-center justify-center">
            <img 
              src="/LS.ico" 
              alt="Landing Smart Logo" 
              className="w-full h-full object-contain"
              onError={(e) => {
                // Caso o arquivo suma ou mude de nome, mostra o texto como plano B
                (e.target as HTMLElement).style.display = 'none';
                const parent = (e.target as HTMLElement).parentElement;
                if(parent) parent.innerText = 'LS';
              }}
            />
          </div>

          {/* Itens de Menu (Ícones) */}
          <nav className="flex flex-col items-center gap-4 w-full px-2">
            <button className="p-3 bg-cyan-500/10 text-cyan-400 rounded-xl transition-all duration-200 cursor-pointer group relative" title="SmartQueue">
              <LayoutDashboard className="w-5 h-5 md:w-6 md:h-6" />
              <span className="absolute left-full ml-2 px-2 py-1 bg-slate-800 text-xs text-slate-200 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none z-50 shadow-md">
                SmartQueue
              </span>
            </button>

            <button className="p-3 text-slate-400 hover:text-slate-200 hover:bg-slate-800/50 rounded-xl transition-all duration-200 cursor-pointer group relative" title="Campanhas">
              <Mail className="w-5 h-5 md:w-6 md:h-6" />
              <span className="absolute left-full ml-2 px-2 py-1 bg-slate-800 text-xs text-slate-200 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none z-50 shadow-md">
                Campanhas
              </span>
            </button>

            <button className="p-3 text-slate-400 hover:text-slate-200 hover:bg-slate-800/50 rounded-xl transition-all duration-200 cursor-pointer group relative" title="Relatórios">
              <BarChart3 className="w-5 h-5 md:w-6 md:h-6" />
              <span className="absolute left-full ml-2 px-2 py-1 bg-slate-800 text-xs text-slate-200 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none z-50 shadow-md">
                Relatórios
              </span>
            </button>
          </nav>
        </div>

        {/* Bloco Inferior: Configurações e Sair */}
        <div className="flex flex-col items-center gap-3 w-full px-2">
          <button className="p-3 text-slate-500 hover:text-slate-300 hover:bg-slate-800/50 rounded-xl transition-all duration-200 cursor-pointer" title="Configurações">
            <Settings className="w-5 h-5" />
          </button>
          <button className="p-3 text-rose-500/70 hover:text-rose-400 hover:bg-rose-500/10 rounded-xl transition-all duration-200 cursor-pointer" title="Sair">
            <LogOut className="w-5 h-5" />
          </button>
        </div>

      </aside>

      {/* 2. ÁREA DE CONTEÚDO PRINCIPAL */}
      <div className="flex-1 flex flex-col min-w-0">
        
        {/* Barra de Topo Discreta */}
        <header className="h-16 border-b border-slate-900 bg-slate-950/50 backdrop-blur-md flex items-center justify-between px-6 md:px-10 shrink-0">
          <div className="flex items-center gap-2">
            <span className="text-xs font-semibold uppercase tracking-widest text-slate-500">
              Landing Smart
            </span>
            <span className="text-slate-600">/</span>
            <span className="text-xs font-medium text-cyan-400 bg-cyan-500/5 px-2 py-0.5 rounded border border-cyan-500/10">
              SmartQueue
            </span>
          </div>
          
          <div className="text-xs text-slate-500 font-medium hidden sm:block">
            Ambiente Local &bull; Redis Ativo
          </div>
        </header>

        {/* Container da Tabela */}
        <main className="flex-1 p-6 md:p-10 overflow-y-auto w-full max-w-7xl mx-auto">
          <QueueTable />
        </main>

      </div>

    </div>
  )
}

export default App