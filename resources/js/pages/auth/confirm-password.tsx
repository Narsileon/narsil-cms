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

function ConfirmPassword() {
  const { trans } = useTranslationsStore();

  return (
    <>
      <Head title={trans("ui.confirm_password", "Confirm password")} />
      <Container
        className="flex flex-col items-center justify-center gap-6"
        asChild={true}
      >
        <Section>
          <SectionHeader>
            <SectionTitle level="h1" variant="h4">
              {trans("ui.confirm_password", "Confirm password")}
            </SectionTitle>
          </SectionHeader>
          <SectionContent>
            <Card className="w-[18rem]">
              <CardContent>
                <FormProvider
                  id="confirm-password-form"
                  initialData={{
                    password: "",
                  }}
                  render={() => (
                    <Form
                      className="grid gap-6"
                      method="post"
                      url={route("password.confirm")}
                    >
                      <FormField
                        name="password"
                        render={({ onChange, ...field }) => (
                          <FormItem>
                            <FormLabel required={true} />
                            <Input
                              autoComplete="one-time-code"
                              type="password"
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

export default ConfirmPassword;
