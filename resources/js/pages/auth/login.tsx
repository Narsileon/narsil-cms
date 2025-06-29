import { Card, CardContent } from "@/components/ui/card";
import { Checkbox } from "@/components/ui/checkbox";
import { Heading } from "@/components/ui/heading";
import { Input } from "@/components/ui/input";
import { Link } from "@inertiajs/react";
import { toast } from "sonner";
import { useEffect, useRef } from "react";
import { route } from "ziggy-js";
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

type LoginProps = {
  status?: string;
};

function Login({ status }: LoginProps) {
  const { trans } = useTranslationsStore();

  const hasStatus = useRef<boolean>(false);

  useEffect(() => {
    if (status && !hasStatus.current) {
      toast.success(status);

      hasStatus.current = true;
    }
  }, [status]);

  return (
    <div className="absolute top-1/2 left-1/2 grid -translate-x-1/2 -translate-y-1/2 transform gap-4">
      <Heading className="text-center" level="h1" variant="h4">
        {trans("ui.connection", "Connection")}
      </Heading>
      <Card className="w-[18rem]">
        <CardContent>
          <FormProvider
            id="login-form"
            initialData={{
              email: "",
              password: "",
              remember: false,
            }}
            render={() => (
              <Form className="grid gap-6" method="post" url={route("login")}>
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
                      <FormMessage />
                    </FormItem>
                  )}
                />
                <FormField
                  name="password"
                  render={({ onChange, ...field }) => (
                    <FormItem>
                      <div className="flex items-center justify-between">
                        <FormLabel required={true} />
                        <Link
                          className="text-xs"
                          href={route("password.request")}
                        >
                          {trans("passwords.link", "Forgot your password?")}
                        </Link>
                      </div>
                      <Input
                        autoComplete="new-password"
                        type="password"
                        onChange={(e) => onChange(e.target.value)}
                        {...field}
                      />
                      <FormMessage />
                    </FormItem>
                  )}
                />
                <FormField
                  name="remember"
                  render={({ value, onChange, ...field }) => (
                    <FormItem className="flex-row">
                      <Checkbox
                        checked={value}
                        onCheckedChange={(checked) => onChange(checked)}
                        {...field}
                      />
                      <FormLabel />
                    </FormItem>
                  )}
                />
                <FormSubmit>{trans("ui.log_in", "Log in")}</FormSubmit>
              </Form>
            )}
          />
          {status}
        </CardContent>
      </Card>
    </div>
  );
}

export default Login;
