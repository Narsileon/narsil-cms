import { Card, CardContent } from "@/components/ui/card";
import { Heading } from "@/components/ui/heading";
import { Input } from "@/components/ui/input";
import { route } from "ziggy-js";
import { useTranslationsStore } from "@/stores/translations-store";
import {
  Form,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
  FormSubmit,
} from "@/components/ui/form";

function Register() {
  const { trans } = useTranslationsStore();

  return (
    <div className="absolute top-1/2 left-1/2 grid -translate-x-1/2 -translate-y-1/2 transform gap-4">
      <Heading className="text-center" level="h1" variant="h4">
        {trans("ui.register")}
      </Heading>
      <Card className="w-[18rem] md:w-[26rem]">
        <CardContent>
          <Form
            id="register-form"
            className="grid gap-6 md:grid-cols-2"
            method="post"
            url={route("register.store")}
          >
            <FormField
              name="email"
              render={({ onChange, ...field }) => (
                <FormItem className="col-span-full">
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
                <FormItem className="col-span-1">
                  <FormLabel required={true} />
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
              name="password_confirmation"
              render={({ onChange, ...field }) => (
                <FormItem className="col-span-1">
                  <FormLabel required={true} />
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
              name="first_name"
              render={({ onChange, ...field }) => (
                <FormItem className="col-span-1">
                  <FormLabel required={true} />
                  <Input
                    autoComplete="given-name"
                    onChange={(e) => onChange(e.target.value)}
                    {...field}
                  />
                  <FormMessage />
                </FormItem>
              )}
            />
            <FormField
              name="last_name"
              render={({ onChange, ...field }) => (
                <FormItem className="col-span-1">
                  <FormLabel required={true} />
                  <Input
                    autoComplete="family-name"
                    onChange={(e) => onChange(e.target.value)}
                    {...field}
                  />
                  <FormMessage />
                </FormItem>
              )}
            />
            <FormSubmit className="col-span-full">
              {trans("ui.register")}
            </FormSubmit>
          </Form>
        </CardContent>
      </Card>
    </div>
  );
}

export default Register;
