import { Card, CardContent } from "@/components/ui/card";
import { Container } from "@/components/ui/container";
import { Head } from "@inertiajs/react";
import { Input } from "@/components/ui/input";
import { route } from "ziggy-js";
import useTranslationsStore from "@/stores/translations-store";
import {
  Form,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
  FormProvider,
  FormSubmit,
} from "@/components/ui/form";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";

function TwoFactorChallenge() {
  const { trans } = useTranslationsStore();

  return (
    <>
      <Head
        title={trans(
          "ui.two_factor_authentication",
          "Two-factor authentication",
        )}
      />
      <Container
        className="flex flex-col items-center justify-center gap-6"
        asChild={true}
      >
        <Section>
          <SectionHeader>
            <SectionTitle level="h1" variant="h4">
              {trans(
                "ui.two_factor_authentication",
                "Two-factor authentication",
              )}
            </SectionTitle>
          </SectionHeader>
          <SectionContent>
            <Card className="w-[18rem]">
              <CardContent>
                <FormProvider
                  id="two-factor-challenge-form"
                  initialData={{
                    code: "",
                    recovery_code: "",
                  }}
                  render={() => (
                    <Form
                      className="grid gap-6"
                      method="post"
                      url={route("two-factor.login")}
                    >
                      <FormField
                        name="code"
                        render={({ onChange, ...field }) => (
                          <FormItem>
                            <FormLabel required={true} />
                            <Input
                              autoComplete="one-time-code"
                              onChange={(e) => onChange(e.target.value)}
                              {...field}
                            />
                            <FormMessage />
                          </FormItem>
                        )}
                      />
                      <FormField
                        name="recovery_code"
                        render={({ onChange, ...field }) => (
                          <FormItem>
                            <FormLabel />
                            <Input
                              autoComplete="one-time-code"
                              onChange={(e) => onChange(e.target.value)}
                              {...field}
                            />
                            <FormMessage />
                          </FormItem>
                        )}
                      />
                      <FormSubmit>{trans("ui.confirm", "Confirm")}</FormSubmit>
                    </Form>
                  )}
                />
              </CardContent>
            </Card>
          </SectionContent>
        </Section>
      </Container>
    </>
  );
}

export default TwoFactorChallenge;
