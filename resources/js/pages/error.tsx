import { Container } from "@narsil-cms/blocks/container";
import { Heading } from "@narsil-cms/blocks/heading";

type ErrorProps = {
  description: string;
  title: string;
};

function Error({ description, title }: ErrorProps) {
  return (
    <Container className="flex h-full items-center justify-center">
      <div className="flex flex-col items-center justify-center gap-4">
        <Heading className="text-center" level="h1" variant="h3">
          {title}
        </Heading>
        <div className="text-center text-base">{description}</div>
      </div>
    </Container>
  );
}

export default Error;
