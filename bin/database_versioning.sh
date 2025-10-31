#!/bin/bash
set -e

# Diretório do repositório
DIR="$HOME/.corsair/projects/daily"
LOG_DIR="${DIR}/var/log"
LOG_FILE="$LOG_DIR/git_daily_$(date +'%Y%m%d').log"

if [ ! -f "$LOG_FILE" ]; then
    # Se o arquivo de log não existir, cria-o
    mkdir -p "$LOG_DIR"
    chmod 777 "$LOG_DIR"
else
    # Se o arquivo de log existir, limpa-o
    echo "" > "$LOG_FILE"
fi

# Inicia log com cabeçalho
{
echo "====================================================="
echo "🕒 Execução iniciada em: $(date)"
echo "====================================================="
} >> "$LOG_FILE"

# Redireciona TUDO (stdout e stderr) para o log
exec >> "$LOG_FILE" 2>&1

cd "$DIR" || exit 1

echo "📁 Diretório atual: $(pwd)"
echo "🔧 Versão do Git: $(git --version)"
echo "🔗 Repositório remoto:"
git remote -v

echo "📥 Atualizando branch local..."
git pull origin main
git status

# Define nomes dos arquivos
YESTERDAY=$(date -d "yesterday" +'%Y%m%d')
TODAY=$(date +'%Y%m%d')

PREV_FILENAME="db_daily_${YESTERDAY}"
TODAY_FILENAME="db_daily_${TODAY}"

PREV_FILEPATH=$(ls backups/db_daily_*.sql 2>/dev/null | grep -v "$TODAY" | sort | tail -n 1)
# PREV_FILEPATH="backups/${PREV_FILENAME}.sql"
TODAY_FILEPATH="backups/${TODAY_FILENAME}.sql"

echo "🧩 Arquivo de backup anterior: ${PREV_FILEPATH}"
echo "🆕 Arquivo de backup atual: ${TODAY_FILEPATH}"

# Remove o arquivo de backup anterior e adiciona a área de commit
if [ -f "$PREV_FILEPATH" ]; then
    # git rm -f "$PREV_FILEPATH"
    rm -f "$PREV_FILEPATH"
    git add "$PREV_FILEPATH"
    echo "✅ Arquivo de backup anterior removido e preparado para o commit."
else
    echo "⚠️ Nenhum arquivo de backup anterior encontrado."
fi

# Cria commit se houver mudanças
if [ -f "$TODAY_FILEPATH" ]; then
    git add "$TODAY_FILEPATH"
    git commit -m "🗃️ Database backup file."
    echo "✅ Commit criado com sucesso."
else
    echo "⚠️ Nenhuma alteração detectada, nada para commitar."
fi

# Realiza push com log detalhado
echo "🚀 Enviando alterações..."
git push origin main -v

# Limpando os arquivos de logs antigos
echo "🧹 Limpando os arquivos de logs antigos."
find "$LOG_DIR" -type f -name "git_daily_*.log" -mtime +5 -delete

echo "======================================================="
echo "🏁 Execução finalizada em: $(date)"
echo "======================================================="

exit 0

# output () {
#     echo -e "$(date +"%Y-%m-%d %H:%M:%S") DEBUG: $1" 
# }

# #----------------------------------------------------------------------------------

# # Diretório onde ficam os arquivos
# DIR="$HOME/.corsair/projects/daily/backups"

# # Message
# MSG_SUCCESS="\033[32m[Success] $(date +"%Y-%m-%d %H:%M:%S")\033[0m"
# MSG_ERROR="\033[31m[Error  ] $(date +"%Y-%m-%d %H:%M:%S")\033[0m"
# MSG_INFO="\033[34m[Info   ] $(date +"%Y-%m-%d %H:%M:%S")\033[0m"

# # LOG FILE
# LOG_FILE="$HOME/.corsair/projects/daily/var/log/git.log"

# # # Data de hoje
# TODAY=$(date +"%Y%m%d")
# TODAY_FILE="db_daily_${TODAY}.sql"

# # Captura o último arquivo anterior ao de hoje
# output "Captura o último arquivo anterior ao de hoje" >> "$LOG_FILE"
# cd "$DIR" || { output "Diretório $DIR não encontrado"; exit 1; }

# PREV_FILE=$(ls db_daily_*.sql 2>/dev/null | grep -v "$TODAY" | sort | tail -n 1)

# output "Arquivo do dia anterior: $PREV_FILE" >> "$LOG_FILE"
# output "Arquivo de hoje: $TODAY_FILE" >> "$LOG_FILE"

# # Se existir arquivo anterior, remove via git
# output "Removendo o arquivo do dia anterior" >> "$LOG_FILE"
# if [ -n "$PREV_FILE" ] && [ -f "$PREV_FILE" ]; then
#     git rm "$DIR/$PREV_FILE" && git add "$DIR/$PREV_FILE"
    
#     output "Aquivo do dia anterior removido e preparado para o commit: $PREV_FILE" >> "$LOG_FILE"
# else
#     output "Nenhum arquivo do dia anterior encontrado" >> "$LOG_FILE"
# fi

# output "Verificando se o arquivo de hoje foi gerado" >> "$LOG_FILE"
# if [ -f "$TODAY_FILE" ]; then
#     output "Arquivo de hoje encontrado: $TODAY_FILE" >> "$LOG_FILE"

#     # Adiciona o arquivo de hoje, comitando e publicando
#     git add "$DIR/$TODAY_FILE" && git commit -m "🗃️ Database backup" && git push origin main

#     output "Arquivo de hoje publicado no repositório" >> "$LOG_FILE"
# else
#     output "O arquivo de hoje não foi gerado: $TODAY_FILE" >> "$LOG_FILE"
# fi

# output "Processo concluído!\n" >> "$LOG_FILE"
