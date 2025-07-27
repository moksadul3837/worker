FROM php:8.2-cli

WORKDIR /app

COPY . /app

RUN apt-get update && apt-get install -y curl

CMD ["php", "otp_forwarder.php"]
