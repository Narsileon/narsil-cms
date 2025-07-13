import { Button } from "@/components/ui/button";
import { Card, CardContent } from "@/components/ui/card";
import { Container } from "@/components/ui/container";
import { Head, Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import { toast } from "sonner";
import { useEffect, useRef } from "react";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";

type VerifyEmailProps = {
  labels: Record<string, string>;
  status: string;
};

function VerifyEmail({ labels, status }: VerifyEmailProps) {
  const hasStatus = useRef<boolean>(false);

  useEffect(() => {
    if (status && !hasStatus.current) {
      toast.success(labels.sent);

      hasStatus.current = true;
    }
  }, [status]);

  return (
    <>
      <Head title={labels.title} />
      <Container className="gap-6" asChild={true} variant="centered">
        <Section>
          <SectionHeader>
            <SectionTitle level="h1" variant="h4">
              {labels.title}
            </SectionTitle>
          </SectionHeader>
          <SectionContent>
            <Card>
              <CardContent className="grid gap-4">
                <p>{labels.instruction}</p>
                <p>{labels.prompt}</p>
                <Button asChild={true}>
                  <Link href={route("verification.send")} method="post">
                    {labels.send_again}
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
