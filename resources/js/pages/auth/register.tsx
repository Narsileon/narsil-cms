import { Input } from "@/components/ui/input";
import { useRoute } from "ziggy-js";
import {
  Form,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from "@/components/ui/form";

const Index = () => {
  const route = useRoute();

  return (
    <Form method="post" url={route("register.store")}>
      <FormField
        name="email"
        render={({ onChange, ...field }) => (
          <FormItem>
            <FormLabel required={true}>Email</FormLabel>
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
            <FormLabel required={true}>Password</FormLabel>
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
          <FormItem>
            <FormLabel required={true}>Password Confirmation</FormLabel>
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
    </Form>
  );
};

export default Index;
