import { Button } from "@/components/ui/button";
import { Card, CardContent } from "@/components/ui/card";
import { Container } from "@/components/ui/container";
import { Head, Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import { toast } from "sonner";
import { useEffect, useRef } from "react";
import { useLabels } from "@/components/ui/labels";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";

type VerifyEmailProps = {
  status: string;
  title: string;
};

function VerifyEmail({ status, title }: VerifyEmailProps) {
  const { getLabel } = useLabels();

  const hasStatus = useRef<boolean>(false);

  useEffect(() => {
    if (status && !hasStatus.current) {
      toast.success(getLabel("verify-email.sent"));

      hasStatus.current = true;
    }
  }, [status]);

  return (
    <>
      <Head title={title} />
      <Container className="gap-6" asChild={true} variant="centered">
        <Section>
          <SectionHeader>
            <SectionTitle level="h1" variant="h4">
              {title}
            </SectionTitle>
          </SectionHeader>
          <SectionContent>
            <Card>
              <CardContent className="grid gap-4">
                <p>{getLabel("verify-email.instruction")}</p>
                <p>{getLabel("verify-email.prompt")}</p>
                <Button asChild={true}>
                  <Link href={route("verification.send")} method="post">
                    {getLabel("verify-email.send_again")}
                  </Link>
                </Button>
              </CardContent>
            </Card>
          </SectionContent>
        </Section>
      </Container>
    </>
  );
}

export default VerifyEmail;
