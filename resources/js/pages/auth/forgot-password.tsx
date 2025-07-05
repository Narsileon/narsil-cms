import { Button } from "@/components/ui/button";
import { Card, CardContent, CardFooter } from "@/components/ui/card";
import { Container } from "@/components/ui/container";
import { Input } from "@/components/ui/input";
import { Head, Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import { toast } from "sonner";
import { useEffect, useRef } from "react";
import useTranslationsStore from "@/stores/translations-store";
import {
  Form,
  FormDescription,
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

type ForgotPasswordProps = {
  status: string;
};

function ForgotPassword({ status }: ForgotPasswordProps) {
  const { trans } = useTranslationsStore();

  const hasStatus = useRef<boolean>(false);

  useEffect(() => {
    if (status && !hasStatus.current) {
      toast.success(status);

      hasStatus.current = true;
    }
  }, [status]);

  return (
    <>
      <Head title={trans("ui.reset_password", "Reset password")} />
      <Container
        className="flex flex-col items-center justify-center gap-6"
        asChild={true}
      >
        <Section>
          <SectionHeader>
            <SectionTitle level="h1" variant="h4">
              {trans("ui.reset_password", "Reset password")}
            </SectionTitle>
          </SectionHeader>
          <SectionContent>
            <Card className="w-[18rem]">
              <CardContent>
                <FormProvider
                  id="forgot-password-form"
                  initialData={{
                    email: "",
                  }}
                  render={() => (
                    <Form
                      className="grid gap-6"
                      method="post"
                      url={route("password.email")}
                    >
                      <FormField
                        name="email"
                        render={({ onChange, ...field }) => (
                          <FormItem>
                            <FormLabel required={true} />
                            <Input
                              autoComplete="email"
                              type="email"
                              onChange={(e) => onChange(e.target.value)}
                              {...field}
                            />
                            <FormDescription>
                              {trans(
                                "passwords.instruction",
                                "Let us know your email address and we will email you a password reset link that will allow you to choose a new one.",
                              )}
                            </FormDescription>
                            <FormMessage />
                          </FormItem>
                        )}
                      />
                      <FormSubmit>{trans("ui.send", "Send")}</FormSubmit>
                    </Form>
                  )}
                />
              </CardContent>
              <CardFooter className="border-t">
                <Button className="w-full" asChild={true} variant="secondary">
                  <Link href={route("login")}>{trans("ui.back", "Back")}</Link>
                </Button>
              </CardFooter>
            </Card>
          </SectionContent>
        </Section>
      </Container>
    </>
  );
}

export default ForgotPassword;
