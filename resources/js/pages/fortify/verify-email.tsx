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
  status: string;
  translations: Record<string, string>;
};

function VerifyEmail({ status, translations }: VerifyEmailProps) {
  const hasStatus = useRef<boolean>(false);

  useEffect(() => {
    if (status && !hasStatus.current) {
      toast.success(translations.sent);

      hasStatus.current = true;
    }
  }, [status]);

  return (
    <>
      <Head title={translations.title} />
      <Container className="gap-6" asChild={true} variant="centered">
        <Section>
          <SectionHeader>
            <SectionTitle level="h1" variant="h4">
              {translations.title}
            </SectionTitle>
          </SectionHeader>
          <SectionContent>
            <Card className="w-[18rem]">
              <CardContent className="grid gap-4">
                <p>{translations.instruction}</p>
                <p>{translations.prompt}</p>
                <Button asChild={true}>
                  <Link href={route("verification.send")} method="post">
                    {translations.send_again}
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
