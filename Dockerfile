FROM jdecode/slackathon:2.2

ARG PORT

ENV PORT "${PORT}"

# Use the PORT environment variable in Apache configuration files.
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf
