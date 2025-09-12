import { Link } from "@inertiajs/react";
import { useEffect, useRef } from "react";
import { toast } from "sonner";
import { route } from "ziggy-js";

import { Button } from "@narsil-cms/components/button";
import { Card, CardContent } from "@narsil-cms/components/card";
import { Container } from "@narsil-cms/components/container";
import { useLabels } from "@narsil-cms/components/labels";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@narsil-cms/components/section";

type VerifyEmailProps = {
  status: string;
  title: string;
};

function VerifyEmail({ status, title }: VerifyEmailProps) {
  const { trans } = useLabels();

  const hasStatus = useRef<boolean>(false);

  useEffect(() => {
    if (status && !hasStatus.current) {
      toast.success(trans("verify-email.sent"));

      hasStatus.current = true;
    }
  }, [status]);

  return (
    <Container className="gap-6" asChild={true} variant="centered">
      <Section>
        <SectionHeader>
          <SectionTitle level="h1" variant="h4">
            {title}
          </SectionTitle>
        </SectionHeader>
        <SectionContent>
          <Card>
            <CardContent>
              <p>{trans("verify-email.instruction")}</p>
              <p>{trans("verify-email.prompt")}</p>
              <Button asChild={true}>
                <Link href={route("verification.send")} method="post">
                  {trans("verify-email.send_again")}
                </Link>
              </Button>
            </CardContent>
          </Card>
        </SectionContent>
      </Section>
    </Container>
  );
}

export default VerifyEmail;
