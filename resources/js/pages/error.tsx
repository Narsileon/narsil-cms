import { Container } from "@narsil-cms/components/ui/container";
import { Heading } from "@narsil-cms/components/ui/heading";

type ErrorProps = {
  description: string;
  title: string;
};

const Error = ({ description, title }: ErrorProps) => {
  return (
    <>
      <Container className="flex h-full items-center justify-center">
        <div className="flex flex-col items-center justify-center gap-4">
          <Heading className="text-center" level="h1" variant="h3">
            {title}
          </Heading>
          <div className="text-center text-xl">{description}</div>
        </div>
      </Container>
    </>
  );
};

export default Error;
