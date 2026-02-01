import { Container } from "@narsil-cms/components/container";
import { Heading } from "@narsil-cms/components/heading";

type ErrorProps = {
  description: string;
  title: string;
};

function Error({ description, title }: ErrorProps) {
  return (
    <Container className="h-[inherit] min-h-[inherit] justify-center" variant="sm">
      <Heading className="text-center" level="h1" variant="h3">
        {title}
      </Heading>
      <div className="text-center text-base">{description}</div>
    </Container>
  );
}

export default Error;
