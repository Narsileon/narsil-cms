import { Button, Card, Container, Heading } from "@narsil-cms/blocks";
import { useLocalization } from "@narsil-cms/components/localization";
import { SectionContent, SectionHeader, SectionRoot } from "@narsil-cms/components/section";
import { useEffect, useRef } from "react";
import { toast } from "sonner";
import { route } from "ziggy-js";

type VerifyEmailProps = {
  status: string;
  title: string;
};

function VerifyEmail({ status, title }: VerifyEmailProps) {
  const { trans } = useLocalization();

  const hasStatus = useRef<boolean>(false);

  useEffect(() => {
    if (status && !hasStatus.current) {
      toast.success(trans("verify-email.sent"));

      hasStatus.current = true;
    }
  }, [status]);

  return (
    <Container className="gap-6" asChild={true} variant="centered">
      <SectionRoot className="animate-in py-4 fade-in-0 slide-in-from-bottom-10">
        <SectionHeader>
          <Heading level="h1" variant="h4">
            {title}
          </Heading>
        </SectionHeader>
        <SectionContent>
          <Card>
            <p>{trans("verify-email.instruction")}</p>
            <p>{trans("verify-email.prompt")}</p>
            <Button
              linkProps={{
                href: route("verification.send"),
                method: "post",
              }}
            >
              {trans("ui.send_again")}
            </Button>
          </Card>
        </SectionContent>
      </SectionRoot>
    </Container>
  );
}

export default VerifyEmail;
